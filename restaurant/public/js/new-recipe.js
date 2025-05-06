const form = document.getElementById('new-recipe-form');
const inputs = form.querySelectorAll('input');
const addIngredientButton = document.getElementById("add-ingredient-button")
const formVariables = {}
const ingredientBubblesContainer = document.getElementById("ingredients-bubbles-container")
const ingredientsAdded = []

// Create variables for each input
inputs.forEach(input => {
    formVariables[input.name] = input;
});

// Add ingredient click handler
function handleAddIngredient(ev) {
    ev.preventDefault()
    let ingredientBubble = document.createElement("div")
    ingredientBubble.classList.add("ingredient-bubble")

    // Should change
    let ingredientName = formVariables.ingredients1.value
    let ingredientQty = formVariables.quantity1.value
    let ingredientType = formVariables.mesurements1.value

    formVariables.ingredients1.value = null
    formVariables.quantity1.value = null
    formVariables.mesurements1.value = null
    
    let ingredientText = document.createElement("span")
    ingredientText.innerText = ingredientName + " " + ingredientQty + ingredientType
    ingredientBubble.appendChild(ingredientText)

    let removeButton = document.createElement("button")
    removeButton.innerText = "X"
    ingredientBubble.appendChild(removeButton)

    // Button functionality
    removeButton.addEventListener("click", (ev) => {
        ev.preventDefault()
        ingredientBubble.remove()
    })

    ingredientBubblesContainer.appendChild(ingredientBubble)
}

async function getSuggestedRecipe(name) {

}

addIngredientButton.addEventListener("click", handleAddIngredient)