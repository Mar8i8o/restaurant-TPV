import { fetchLoggedUserInfo, logOut } from './utils.js'

const LOGOUT_BUTTON = document.getElementById("logOut_button")
LOGOUT_BUTTON.addEventListener("click", logOut)

fetchLoggedUserInfo()