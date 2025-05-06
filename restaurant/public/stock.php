<?php 
    include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/php/verifyLogged.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock</title>

    <link rel="stylesheet" href="./css/stock.css">
    <script defer type="module" src="./js/stock.js"></script>
</head>
<body>
    <nav>
        <div>
            <img src="./img/ccsLogoWhite.png" alt="Cook Code System Logo">
        </div>
        <ul>
            <a href="dashboard.php"><li> <object data="./svg/dashboard.svg" type="image/svg+xml"></object>Dashboard</li></a>
            <a href="analytics.php"><li> <object data="./svg/graph.svg" type=""></object>Analytics</li></a>
            <a href="stock.php"><li> <object data="./svg/stock.svg" type=""></object>Stock</li></a>
            <a href="receipts.php"><li> <object data="./svg/receipt.svg" type=""></object>Pre-prepareds</li></a>
          
            <a href="dishes.php"><li> <object data="./svg/receipt.svg" type=""></object>Dishes</li></a>
            <a href="orders.php"><li> <object data="./svg/orders.svg" type=""></object>Orders</li></a>
            <a href="tpv.html"><li> <object data="./svg/tpv.svg" type=""></object>TPV</li></a>
            <a href="settings.php"><li> <object data="./svg/settings.svg" type=""></object>Settings</li></a>   
        </ul>
        <script defer> // Botón a woocommerce
            document.addEventListener('DOMContentLoaded', function(){
    
            
            document.getElementById('loginButtonEcommerce').addEventListener('click', function(event) {
                const username = event.target.getAttribute('data-username');
                const password = event.target.getAttribute('data-password');
    
                
                const formData = new FormData();
                formData.append('log', username);
                formData.append('pwd', password);
                formData.append('rememberme', true);
                formData.append('wp-submit', 'Log In');
                formData.append('redirect_to', 'http://localhost:8080/ecommerce/'); //Cuando acabe el login redirecciona a la tienda
                formData.append('testcookie', 1);
    
                fetch('http://localhost:8080/ecommerce/wp-login.php', {
                    method: 'POST',
                    body: formData,
                    credentials: 'include' 
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                    } else {
                        throw new Error('El usuario o contraseña no es válido');
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
            });
        });
        </script>
    </nav>
    
    <main>
        
        <section>            
            <h2 id="mainTitle">Stock</h2>
            <table id="stockTable">
                <div id="tableNav">
                    <div>
                        <button id="filter-button">FILTER</button>
                        <button id="filter-button">ORDER BY</button>
                    </div>
                    <button type="button" id="loginButtonEcommerce" data-username="cliente1@gmail.com" data-password="^nmZ^jm(%DS8zWhnDUUffeQ&">Online Store</button>
                </div>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product name</th>
                        <th>Qty</th>
                        <th>Expiration</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="stock-tbody">
                    <tr>
                        <td>#1234</td>
                        <td>Tomates</td>
                        <td>4 Kg</td>
                        <td>26/09/2024</td>
                        <td><object data="./svg/settingsB.svg" type=""></object></td>
                    </tr>
                    <tr>
                        <td>#234</td>
                        <td>Aceite</td>
                        <td>2 L</td>
                        <td style="color: red;">10/04/2024 ⚠️</td>
                        <td><object data="./svg/settingsB.svg" type=""></object></td>
                    </tr>
                    <tr>
                        <td>#12</td>
                        <td>Botella de Agua 0.5L</td>
                        <td>14 Ud</td>
                        <td>26/09/2024</td>
                        <td><object data="./svg/settingsB.svg" type=""></object></td>
                    </tr>
                    <tr>
                        <td>#112</td>
                        <td>Salsa Boloñesa</td>
                        <td>5 L</td>
                        <td style="color: orange;">31/04/2024</td>
                        <td><object data="./svg/settingsB.svg" type=""></object></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section>
            <h3>Change Log</h3>
            <table id="logTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Action type</th>
                        <th>Table</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tr>
                    <td>#124</td>
                    <td>Tomates</td>
                    <td>❌ ELIMINATE</td>
                    <td>STOCK</td>
                    <td>2 uds</td>
                </tr>
                <tr>
                    <td>#134</td>
                    <td>Sal</td>
                    <td>❌ ELIMINATE</td>
                    <td>STOCK</td>
                    <td>1 uds</td>
                </tr>
                <tr>
                    <td>#12</td>
                    <td>Espaguetis Boloñesa</td>
                    <td>✅ ADD</td>
                    <td>STOCK</td>
                    <td>12 uds</td>
                </tr>
            </table>
        </section>
    </main>
</body>
</html>