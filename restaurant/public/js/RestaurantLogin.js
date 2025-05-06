import { loginToRestaurantAdmin, createUser, fetchUsersInRestaurant } from './utils.js'
import { createWindow } from './createWindow.js'

class RestaurantLogin extends HTMLElement {
    static observedAttributes = ["idRestaurant", "RestaurantName"]
    
    constructor() {
        super()
        this.render()
        }
        
        render() {
        const RESTAURANT_ID = this.getAttribute("idRestaurant")
        const RESTAURANT_NAME = this.getAttribute("RestaurantName")

        let li = document.createElement("li")
        let span = `<span>#${RESTAURANT_ID} ${RESTAURANT_NAME}</span>`

        // Button login
        let buttonLogIn = document.createElement("button")
        buttonLogIn.innerText = "LOG IN"
        buttonLogIn.addEventListener('click',(ev) => {
            loginToRestaurantAdmin(RESTAURANT_ID)
        })

        // Users Button
        let button = document.createElement("button")
        button.innerText = "USERS"
        button.addEventListener('click', this.usersButton)

        li.innerHTML = span
        li.appendChild(button)
        li.appendChild(buttonLogIn)

        this.appendChild(li)
    }

    usersButton = () => {
        const RESTAURANT_ID = this.getAttribute("idRestaurant")
        let usersWindow = createWindow("Users")
        let uiWindow = usersWindow.getElementsByClassName("uiWindow")
        uiWindow = uiWindow[0]
        
        // Add user
        let addUser = document.createElement("div")
        addUser.classList.add("add-user")
        let user = document.createElement("input")
        user.placeholder = "Usuario"
        let pass = document.createElement("input")
        pass.placeholder = "Contraseña"
        
        let tipo = document.createElement("select")
        tipo.placeholder = "Tipo de usuario"
        let tipo1 = document.createElement("option")
        tipo1.value = 1
        tipo1.text = "Admin"
        tipo.appendChild(tipo1)
        let tipo2 = document.createElement("option")
        tipo2.value = 2
        tipo2.text = "Cocinero"
        tipo.appendChild(tipo2)

        let sendBtn = document.createElement("button")
        sendBtn.innerText = "Añadir Usuario"
        sendBtn.addEventListener("click", (ev) => {
            ev.preventDefault()
            createUser(RESTAURANT_ID, user.value, pass.value, tipo.value)
            location.reload()
        })

        addUser.appendChild(user)
        addUser.appendChild(pass)
        addUser.appendChild(tipo)
        addUser.appendChild(sendBtn)

        uiWindow.appendChild(addUser)
        document.body.appendChild(usersWindow)
        

        // User list
        let userList = document.createElement("div")
        userList.classList.add("user-list")
        let span = document.createElement("span")
        span.innerText = "Usuarios"
        let userUl = document.createElement("ul")
        fetchUsersInRestaurant(RESTAURANT_ID).then((users) => {
            if(users) {
                users.forEach(user => {
                    let foo = document.createElement("li")
                    let bar = ""
                    if(user.tipo_usuario_id === 1) {bar = "Gerente"}
                    else {bar = "Cocinero"}
                    foo.innerText = `#${user.usuario_id} ${user.nombre} - [${bar}]`
                    userUl.appendChild(foo)
                });
            }
        })


        userList.appendChild(span)
        userList.appendChild(userUl)

        uiWindow.appendChild(userList)
    }
}

customElements.define("restaurant-login", RestaurantLogin)