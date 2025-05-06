import { createWindow } from "./createWindow.js"

class RecipeList extends HTMLElement {
    constructor() {
        super();
    }

    async connectedCallback() {
        if (!await this.render()) {
            return false;
        }
    }

    async fetchRecipes() {
        try {
            const response = await fetch("./api/getRecipes.php");
            if (!response.ok) {
                throw new Error("Error fetching recipes data");
            }
            return response.json();
        } catch (e) {
            console.error("Error fetching recipes data", e);
            return [];
        }
    }

    async render() {
        const recipesData = await this.fetchRecipes();

        if (!recipesData || recipesData.length === 0) {
            this.innerHTML = "<p>No hay recetas disponibles</p>";
            return;
        }
        
        // Crear el contenedor para todas las recetas
        this.classList.add("recipes-list-container");
        recipesData.forEach(recipe => {
            const recipeContainer = this.createRecipeElement(recipe);
            this.appendChild(recipeContainer);
        });
    }

    createRecipeElement(recipeData) {



        // Crear un contenedor para cada receta como una tarjeta
        const recipeContainer = document.createElement('div');
        recipeContainer.className = 'receipt-container'; // Clase para las tarjetas

        let image = document.createElement('img');
        image.src = recipeData.imagen; // Asegúrate de tener la columna 'imagen' en tu base de datos
        image.alt = recipeData.nombre;

        let infoContainer = document.createElement('div');
        infoContainer.className = 'receipt-container-info';

        let title = document.createElement('h3');
        title.textContent = recipeData.nombre; // Campo 'nombre' en la base de datos

        let hr = document.createElement('hr')

        let paragraph = document.createElement('p');
        paragraph.textContent = recipeData.descripcion_corta; // Campo 'descripcion' en la base de datos

        infoContainer.appendChild(title);
        infoContainer.appendChild(hr)
        infoContainer.appendChild(paragraph);

        recipeContainer.appendChild(image);
        recipeContainer.appendChild(infoContainer);

        // Agregar evento de clic para mostrar los detalles de la receta
        recipeContainer.addEventListener('click', () => {
            this.showRecipeDetails(recipeData);
        });

        return recipeContainer;
    }

    showRecipeDetails(recipeData) {


        // Crear la ventana emergente con los detalles de la receta
        let popUpContainer = createWindow(recipeData.nombre, true);
        let uiWindow = popUpContainer.getElementsByClassName("uiWindow")[0];

        uiWindow.classList.add("receipt-window");

        let main = document.createElement("div");
        main.classList.add("receipt-window-main");

        let section1 = document.createElement("section");
        let instrucciones = document.createElement("p");
        instrucciones.innerHTML = recipeData.descripcion.replace(/\n/g, '<br>');;  // Instrucciones de la receta
        section1.appendChild(instrucciones);

        let aside = document.createElement("aside");

        let asideImg = document.createElement("img");
        asideImg.src = recipeData.imagen; // Usar el campo 'imagen'
        aside.appendChild(asideImg);

        let asideDesc = document.createElement("p");
        asideDesc.innerText = recipeData.descripcion_corta; // Usar el campo 'descripcion'
        aside.appendChild(asideDesc);

        let btnDiv = document.createElement("div");
        btnDiv.classList.add("div-btn");
        aside.appendChild(btnDiv);

        let printBtn = document.createElement("button");
        let printBtnIcon = document.createElement("img");
        printBtnIcon.src = "./svg/print.svg";
        printBtn.appendChild(printBtnIcon);
        btnDiv.appendChild(printBtn);
        printBtn.addEventListener("click", () => { window.print() });

        let pdfBtn = document.createElement("button");
        let downloadBtnIcon = document.createElement("img");
        downloadBtnIcon.src = "./svg/download.svg";
        pdfBtn.appendChild(downloadBtnIcon);
        btnDiv.appendChild(pdfBtn);
        pdfBtn.addEventListener("click", () => { window.save(recipeData.nombre + ".pdf") });

        main.appendChild(section1);
        main.appendChild(aside);
        uiWindow.appendChild(main);
        document.body.appendChild(popUpContainer);
    }
}

customElements.define("recipe-list", RecipeList);
