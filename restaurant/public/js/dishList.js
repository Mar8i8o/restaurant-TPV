import { createWindow } from "./createWindow.js";

class DishList extends HTMLElement {
    constructor() {
        super();
    }

    async connectedCallback() {
        if (!await this.render()) {
            return false;
        }
    }

    async fetchDishes() {
        try {
            const restaurantId = localStorage.getItem("restaurant_id"); // Obtener el ID del localStorage
            if (!restaurantId) {
                throw new Error("No restaurant_id found in localStorage");
            }
    
            const response = await fetch(`./api/getDishes.php?restaurant_id=${restaurantId}`);
            if (!response.ok) {
                throw new Error("Error fetching dishes data");
            }
            
            return response.json();
        } catch (e) {
            console.error("Error fetching dishes data", e);
            return [];
        }
    }
    

    async render() {
        const dishesData = await this.fetchDishes();

        if (!dishesData || dishesData.length === 0) {
            this.innerHTML = "<p>No hay platos disponibles</p>";
            return;
        }

        // Create the container for all dishes
        this.classList.add("dishes-list-container");
        dishesData.forEach(dish => {
            const dishContainer = this.createDishElement(dish);
            this.appendChild(dishContainer);
        });
    }

    createDishElement(dishData) {
        // Create a container for each dish as a card
        const dishContainer = document.createElement('div');
        dishContainer.className = 'dish-container'; // Class for the cards

        let image = document.createElement('img');
        image.src = dishData.imagen || 'path_to_default_image.jpg'; // Use a default image if missing
        image.alt = dishData.nombre || 'Dish'; // Default alt text

        let infoContainer = document.createElement('div');
        infoContainer.className = 'dish-container-info';

        let title = document.createElement('h3');
        title.textContent = dishData.nombre || 'Sin nombre'; // Default title

        let hr = document.createElement('hr');

        let paragraph = document.createElement('p');
        paragraph.textContent = dishData.instrucciones || 'No hay instrucciones disponibles'; // Default instructions

        infoContainer.appendChild(title);
       // infoContainer.appendChild(hr);
      //  infoContainer.appendChild(paragraph);

        dishContainer.appendChild(image);
        dishContainer.appendChild(infoContainer);

        // Add click event to show dish details
        dishContainer.addEventListener('click', () => {
            this.showDishDetails(dishData);
        });

        return dishContainer;
    }

    showDishDetails(dishData) {
        // Create a pop-up window with dish details
        let popUpContainer = createWindow(dishData.nombre, true);
        let uiWindow = popUpContainer.getElementsByClassName("uiWindow")[0];
    
        uiWindow.classList.add("dish-window");
    
        let main = document.createElement("div");
        main.classList.add("dish-window-main");
    
        // Aquí, incluir los preelaborados e ingredientes directamente
        let ingredientsAndPreelaboradosDiv = document.createElement("div");
    
        // Sección de Preelaborados
        if (dishData.pre_elaborados && dishData.pre_elaborados.length > 0) {
            let preelaboradosSection = document.createElement("section");
            let preelaboradosTitle = document.createElement("h4");
            preelaboradosTitle.textContent = "Preelaborados";
            preelaboradosSection.appendChild(preelaboradosTitle);
    
            dishData.pre_elaborados.forEach(preelaborado => {
                let preelaboradoItem = document.createElement("p");
                preelaboradoItem.textContent = `${preelaborado.nombre} - ${preelaborado.cantidad}`;
                preelaboradosSection.appendChild(preelaboradoItem);
            });
    
            ingredientsAndPreelaboradosDiv.appendChild(preelaboradosSection);
        }
    
        // Sección de Ingredientes
        if (dishData.ingredients && dishData.ingredients.length > 0) {
            let ingredientesSection = document.createElement("section");
            let ingredientesTitle = document.createElement("h4");
            ingredientesTitle.textContent = "Ingredientes";
            ingredientesSection.appendChild(ingredientesTitle);
    
            dishData.ingredients.forEach(ingrediente => {
                let ingredienteItem = document.createElement("p");
                ingredienteItem.textContent = `${ingrediente.nombre} - ${ingrediente.cantidad} ${ingrediente.unidad}`;
                ingredientesSection.appendChild(ingredienteItem);
            });
    
            ingredientsAndPreelaboradosDiv.appendChild(ingredientesSection);
        }
    
        // Agregar sección de ingredientes y preelaborados al contenedor principal
        main.appendChild(ingredientsAndPreelaboradosDiv);
    
        // Instrucciones del plato
        let section1 = document.createElement("section");
        let instrucciones = document.createElement("p");
        instrucciones.innerHTML = dishData.instrucciones.replace(/\n/g, '<br>') || 'No hay instrucciones disponibles'; // Dish instructions
        section1.appendChild(instrucciones);
        main.appendChild(section1);
    
        // Aside con la imagen y el nombre del plato
        let aside = document.createElement("aside");
    
        let asideImg = document.createElement("img");
        asideImg.src = dishData.imagen || 'path_to_default_image.jpg'; // Use a default image if missing
        aside.appendChild(asideImg);
    
        let asideDesc = document.createElement("p");
        asideDesc.innerText = dishData.nombre || 'Sin nombre'; // Use the 'nombre' field for description
        aside.appendChild(asideDesc);
    
        // Agregar aside a main
        main.appendChild(aside);
    
        // Agregar botón para imprimir
        let btnDiv = document.createElement("div");
        btnDiv.classList.add("div-btn");
        aside.appendChild(btnDiv);
    
        let printBtn = document.createElement("button");
        let printBtnIcon = document.createElement("img");
        printBtnIcon.src = "./svg/print.svg"; // Path to the print icon
        printBtn.appendChild(printBtnIcon);
        btnDiv.appendChild(printBtn);
        printBtn.addEventListener("click", () => { window.print() });
    
        // Agrega el contenedor principal a la ventana emergente
        uiWindow.appendChild(main);
        document.body.appendChild(popUpContainer);
    }
}

customElements.define("dish-list", DishList);
