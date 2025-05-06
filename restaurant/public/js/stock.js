import {createWindow} from "./createWindow.js"
import {fetchStockOfRestaurant, removeStockProductById} from "./utils.js"

function handleFilter() {
    let window = createWindow("Filter", true)
    document.body.appendChild(window)
}

function handleOrder() {
    let orderBy = document.createElement("select")
    let orderOptions =  ["ID", "Product Name", "Qty", "PVP"]

    orderOptions.forEach(() => {

    })

    let window = createWindow("Filter", true)
    document.body.appendChild(window)
}

// Sin uso, se eliminó botón de add
function handleAdd() {
    let window = createWindow("Add", true)
    let uiWindow = window.getElementsByClassName("uiWindow")
    uiWindow = uiWindow[0]

    uiWindow.setAttribute("action", "./api/addProduct.php")

    uiWindow.classList.add("uiWindow-add")

    // Input 1
    let label1 = document.createElement("label")
    label1.innerText = "Name"
    uiWindow.appendChild(label1)

    let input1 = document.createElement("input")
    input1.type = "text"
    input1.name = "name"
    uiWindow.appendChild(input1)

    //div
    let div1 = document.createElement("div")
    uiWindow.appendChild(div1)

    // Input 2
    let label2 = document.createElement("label")
    label2.innerText = "Qty"
    div1.appendChild(label2)

    let input2 = document.createElement("input")
    input2.type = "number"
    input2.name = "Qty"
    div1.appendChild(input2)

    // Input 2.1
    let label21 = document.createElement("label")
    label21.innerText = "Unity"
    div1.appendChild(label21)

    let input21 = document.createElement("input")
    input21.setAttribute("list", "unityTypes")
    input21.name = "unity"
    div1.appendChild(input21)

    let datalist = document.createElement("datalist")
    datalist.id="unityTypes"

    let unityList = ["Kg", "Ud", "L"]
    
    unityList.forEach((unity) => {
        let option = document.createElement("option")
        option.value = unity
        datalist.appendChild(option)
    })

    div1.appendChild(datalist)

    // Input 3 has receipt
    let label3 = document.createElement("label")
    label3.innerText = "Has a receipt?"
    div1.appendChild(label3)

    let input3 = document.createElement("input")
    input3.type = "checkbox"
    input3.name = "hasReceipt"
    div1.appendChild(input3)

    // Checkbox extra
    input3.addEventListener("click", () => {
        if (input3.checked) {
            let label = document.createElement("label")
            label.innerText = "Receipt"
    
            let input = document.createElement("input")
            input.id = "dataset"
            input.name = "receipt"
            input.setAttribute("list", "receipts")
    
            let datalist = document.createElement("datalist")
            datalist.id="receipts"
    
            // fetch receipts
    
            let receiptsList = ["Receipt1", "Receipt2", "..."]
    
            receiptsList.forEach((receipt) => {
                let option = document.createElement("option")
                option.value = receipt
                datalist.appendChild(option)
            })

            let div = document.createElement("div")
            div.id = "receiptInputs"
            div.appendChild(label)
            div.appendChild(input)
            div.appendChild(datalist)

            div1.after(div)
        } else {
            document.getElementById("receiptInputs").remove()
        }


    })

    let input4 = document.createElement("input")
    input4.type = "submit"
    uiWindow.appendChild(input4)

    document.body.appendChild(window)
}

async function actualizarStock() {
    const TABLE_BODY = document.getElementById("stock-tbody")
    TABLE_BODY.innerHTML = ""
    const RESTAURANT_ID = localStorage.getItem("restaurant_id")
    const STOCK = await fetchStockOfRestaurant(RESTAURANT_ID)

    STOCK.forEach(element => {
        let tr = document.createElement("tr")
        let tdId = document.createElement("td")
        tdId.innerText = element.id
        tr.appendChild(tdId)
    
        let tdProducto = document.createElement("td")
        element.elaborado_nombre 
            ? tdProducto.innerText = element.elaborado_nombre 
            : tdProducto.innerText = element.ingrediente_nombre 
        tr.appendChild(tdProducto)

        let tdQty = document.createElement("td")
        tdQty.innerText = element.cantidad_stock + " " + element.tipo_unidad_unidad
        tr.appendChild(tdQty)

        let tdCad = document.createElement("td")
        tdCad.innerText = element.caducidad
        tdCad.style.fontWeight = "bold"
        tr.appendChild(aplicarColorCaducidad(tdCad))

        let tdAct = document.createElement("td")
        let actButton = document.createElement("button")
        actButton.innerHTML = `<img src="./svg/settingsB.svg"></img>`
        actButton.addEventListener("click", handleClickActionsStock)
        tdAct.appendChild(actButton)
        tr.appendChild(tdAct)
        TABLE_BODY.appendChild(tr)
    });
}

function aplicarColorCaducidad(caducidad) {
    let cad = caducidad.innerText
    cad = cad.split("-")
    const cadDate = new Date(cad[0], cad[1] - 1, cad[2])
    const actualDate = new Date()
    const diffDate = Math.ceil((cadDate-actualDate) / (1000 * 3600 * 24))
    console.log(diffDate)

    if (diffDate < 0) {
        caducidad.style.color = "#801500"
        caducidad.innerText = caducidad.innerText + " ❌"
    } else if (diffDate < 7) {
        caducidad.style.color = '#E69900'
        caducidad.innerText = caducidad.innerText + " ⚠️"
    } else if (diffDate <= 14) {
        caducidad.style.color = '#95B300'
    } else {
        caducidad.style.color = '#009900'
    }

    return caducidad
}

function handleClickActionsStock(ev) {
    // Datos de la fila
    const row = ev.srcElement.parentNode.parentNode.parentNode
    const cols = row.querySelectorAll("td")
    const rowData = {
        id: cols[0],
        product: cols[1],
        quantity: cols[2],
        caducity: cols[3],
        actions: cols[4]
    }

    // Generar ventana
    let window = createWindow((rowData.id.innerText + " " + rowData.product.innerText), true)
    document.body.appendChild(window)
    let uiWindow = window.getElementsByClassName("uiWindow")
    uiWindow = uiWindow[0] // Body del popup

    let borrarBtn = document.createElement("button")
    borrarBtn.innerText = "Eliminar"
    borrarBtn.addEventListener("click", (ev) => {
        ev.preventDefault()
        if(confirm(`Estás seguro que quieres borrar "${rowData.id.innerText} - ${rowData.product.innerText} - ${rowData.quantity.innerText}"?`)){
            removeStockProductById(rowData.id.innerText)
            location.reload()
        }
    })
    
    uiWindow.appendChild(borrarBtn)


}

actualizarStock()

document.getElementById("filter-button").addEventListener("click", () => {
    handleFilter()
})

/* document.getElementById("add-button").addEventListener("click", () => {
    handleAdd()
}) */