export async function loginToRestaurant(RESTAURANT_ID) {
    let requestData = {
        isAdmin: true,
        restaurant_id: RESTAURANT_ID,
    }
    
    try {
        const response = await fetch("/restaurant/public/api/loginToAccount.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(requestData),
        })
        
        if (!response.ok) {
            throw new Error('Network response was not ok')
        }
        
        const data = await response.json()
        
        if (data.redirectUrl) {
            // Cookie data
            localStorage.setItem("restaurant_id", RESTAURANT_ID)

            // Redirect the user using JavaScript
            window.location.href = data.redirectUrl
        } else {
            console.error('Redirect URL is missing in the response')
        }
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error)
    }
}

export async function loginToRestaurantAdmin(RESTAURANT_ID) {
    let requestData = {
        isAdmin: true,
        restaurant_id: RESTAURANT_ID,
    }
    
    try {
        const response = await fetch("/restaurant/public/api/loginToAccountAdmin.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(requestData),
        })
        
        if (!response.ok) {
            throw new Error('Network response was not ok')
        }
        
        const data = await response.json()
        
        if (data.redirectUrl) {
            // Cookie data
            localStorage.setItem("restaurant_id", RESTAURANT_ID)

            // Redirect the user using JavaScript
            window.location.href = data.redirectUrl
        } else {
            console.error('Redirect URL is missing in the response')
        }
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error)
    }
}

export async function fetchLoggedUserInfo() {
    try {
        const response = await fetch("/restaurant/public/api/getLoggedInfo.php")
        
        if (!response.ok) {
            throw new Error('Network response was not ok')
        }
        
        const data = await response.json()

        const USER_CONTAINERS = document.getElementsByClassName("user_data-username")
        const RESTAURANT_CONTAINERS = document.getElementsByClassName("user_data-restaurant")
        
        Array.from(USER_CONTAINERS).forEach(element => {
            element.innerText = data.username
        })
    
        Array.from(RESTAURANT_CONTAINERS).forEach((element) => {
            element.innerText = data.restaurant
        })
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error)
    }

}

export async function createUser(restaurant, username, password, type) {
    let requestData = {
        user_name: username,
        user_password: password,
        user_type: type,
        user_restaurant: restaurant,
    }
    
    try {
        const response = await fetch("/restaurant/public/api/addUser.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(requestData),
        })
        
        if (!response.ok) {
            throw new Error('Network response was not ok')
        }
        
        const data = await response.json()
        
        if (data.json) {
            console.log(data.json)
        } else {
            console.error('Error!')
        }
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error)
    }
}

export async function fetchUsersInRestaurant(restaurant_id) {
    let requestData = {
        restaurant_id: restaurant_id,
    }
    
    try {
        const response = await fetch("/restaurant/public/api/getUsersOfRestaurant.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(requestData),
        })
        
        if (!response.ok) {
            throw new Error('Network response was not ok')
        }
        
        const data = await response.json()
        
        return data

    } catch (error) {
        console.error('There was a problem with the fetch operation:', error)
    }
}

export function logOut() {
    document.cookie = "PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;"
    localStorage.removeItem("restaurant_id")
    location.reload()
}

export async function fetchStockOfRestaurant(restaurant_id) {
    let requestData = {
        restaurant_id: restaurant_id,
    }
    
    try {
        const response = await fetch("/restaurant/public/api/getStock.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(requestData),
        })
        
        if (!response.ok) {
            throw new Error('Network response was not ok')
        }
        
        const data = await response.json()
        
        return data

    } catch (error) {
        console.error('There was a problem with the fetch operation:', error)
    }
}

export async function removeStockProductById(id) {
    let requestData = {
        id: id,
    }
    
    try {
        const response = await fetch("/restaurant/public/api/removeStockById.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(requestData),
        })
        
        if (!response.ok) {
            throw new Error('Network response was not ok')
        }
        
        const data = await response.json()
        
        return data

    } catch (error) {
        console.error('There was a problem with the fetch operation:', error)
    }
}
