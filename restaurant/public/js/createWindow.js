export function createWindow(title, blur = true) {
    let uiWindow = document.createElement("form")
    uiWindow.classList.add("uiWindow")

    let nav = document.createElement("div")
    nav.classList.add("uiWindow-nav")

    let h3 = document.createElement("h3")
    h3.innerText = title
    nav.appendChild(h3)

    let closeButton = document.createElement("button")
    /* let closeIcon = document.createElement("object")
    closeIcon.data = "./svg/closeCross.svg" */

    let closeIcon = document.createElement("span")
    closeIcon.innerText = "X"

    closeButton.appendChild(closeIcon)
    nav.appendChild(closeButton)

    uiWindow.appendChild(nav)

    let bg = document.createElement("article")
    
    if (blur) {
        bg.classList.add("uiWindow-blurBg")
    } else {
        bg.classList.add("uiWindow-bg")
    }

    bg.appendChild(uiWindow)

    // Closing events
    bg.addEventListener("click", (ev) => {
        if (ev.target == bg) {
            bg.remove()
        }
    })

    closeButton.addEventListener("click", (ev) => {
        bg.remove()

    })

    return bg
}

