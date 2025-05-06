import { createWindow } from "./createWindow.js"

class Recipe extends HTMLElement {
    constructor() {
        super();
    }

    async connectedCallback() {
        if (!await this.render()) {
            return false
        }
    }

    async fetchInfo() {
        let recipeId = this.attributes.recipeId.value;

        const response = await fetch("./api/getRecipe.php?recipeId=" + recipeId);

        try {

            if (!response.ok) {
                throw new Error("Error fetching recipe data");
            }

            return response.json();
        } catch (e) {
            return false
        }
    }










    //Create elements
    async render() {
        
          /**
        const recipeData = await this.fetchInfo();
       
                if (!recipeData) {
                    // Maybe doesnt work
                    this.remove()
        
                    return
                } 


 // Asignar los datos de la receta obtenidos de la base de datos
        this.imgSrc = recipeData.image;  // Campo 'image' que debe estar en tu base de datos
        this.receiptTitle = recipeData.name;  // Campo 'name' en la base de datos
        this.receiptDesc = recipeData.description;  // Campo 'description' en la base de datos
        this.receiptInstructions = recipeData.instructions;  // Campo 'instructions' en la base de datos
*/
        
                this.imgSrc = './img/boloñesa.jpg'
                this.receiptTitle = 'Espaguetis boloñesa [14min]'
                this.receiptDesc = 'Un plato de espaguetis con salsa boloñesa.'
                this.receiptInstructions = '1. Hervir 80g de <a href="#">[Espaguetis]</a> durante 12min <br> 2. Calentar <a href="#">[Bolsa salsa boloñesa]</a> durante 2min <br> 3. Enplatar y agregar una pizca de <a href="#">[Orégano]</a> <br> 4. Acompañar con <a href="#">[Queso parmesano en polvo]</a>'
      

       




        // Component HTML
        this.classList.add("receipt-container")
        let receiptContainer = document.createElement('div')
        receiptContainer.className = 'receipt-container'

        let image = document.createElement('img')
        image.src = this.imgSrc
        image.alt = this.receiptTitle

        let infoContainer = document.createElement('div')
        infoContainer.className = 'receipt-container-info'

        let title = document.createElement('h3')
        title.textContent = this.receiptTitle

        let hr = document.createElement('hr')

        let paragraph = document.createElement('p')
        paragraph.textContent = this.receiptDesc

        infoContainer.appendChild(title)
        infoContainer.appendChild(hr)
        infoContainer.appendChild(paragraph)

        this.appendChild(image)
        this.appendChild(infoContainer)

        this.addEventListener("click", this.handleClick)

    }

    handleClick(ev) {
        let popUpContainer = createWindow(this.receiptTitle, true)
        let uiWindow = popUpContainer.getElementsByClassName("uiWindow")
        uiWindow = uiWindow[0]

        uiWindow.classList.add("receipt-window")

        let main = document.createElement("div")
        main.classList.add("receipt-window-main")

        let section1 = document.createElement("section")
        let instrucciones = document.createElement("p")
        instrucciones.innerHTML = this.receiptInstructions
        section1.appendChild(instrucciones)

        let aside = document.createElement("aside")

        let asideImg = document.createElement("img")
        asideImg.src = this.imgSrc
        aside.appendChild(asideImg)

        let asideDesc = document.createElement("p")
        asideDesc.innerText = this.receiptDesc
        aside.appendChild(asideDesc)

        let btnDiv = document.createElement("div")
        btnDiv.classList.add("div-btn")
        aside.appendChild(btnDiv)

        let printBtn = document.createElement("button")
        let printBtnIcon = document.createElement("img")
        printBtnIcon.src = "./svg/print.svg"
        printBtn.appendChild(printBtnIcon)
        btnDiv.appendChild(printBtn)
        printBtn.addEventListener("click", () => { window.print() })

        let pdfBtn = document.createElement("button")
        let downloadBtnIcon = document.createElement("img")
        downloadBtnIcon.src = "./svg/download.svg"
        pdfBtn.appendChild(downloadBtnIcon)
        btnDiv.appendChild(pdfBtn)
        pdfBtn.addEventListener("click", () => { window.save(this.receiptTitle + ".pdf") })

        main.appendChild(section1)
        main.appendChild(aside)
        uiWindow.appendChild(main)
        document.body.appendChild(popUpContainer)
    }

    handlePrint() {
        window.print()
    } 
}

customElements.define("recipe-component", Recipe);
