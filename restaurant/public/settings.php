<?php 
    include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/php/verifyLogged.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/settings.css">
    <title>Receipts</title>
    <script type="module" src="./js/settings.js" defer></script>
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
    </nav>
    
    <main>
        <h2 id="mainTitle">Settings</h2>
        <div id="infoBubbles">
            <section class="infoBubble">
                <h3>Cuenta de Usuario</h3>
                <h4>Información:</h4>
                <p>Id de restaurante: <span class="user_data-restaurant">ERROR</span></p>
                <p>Usuario: <span class="user_data-username">ERROR</span></p>
                <button id="logOut_button">Cerrar sesión</button>
            </section>
            <section class="infoBubble">
                <h3>Restaurante</h3>
                <h4>Información:</h4>
                <p>Id de restaurante: <span class="user_data-restaurant">ERROR</span></p>
            </section>
        </div>
    </main>
</body>
</html>