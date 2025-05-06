<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/php/verifyLogged.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dishes.css">
   
    <script defer type="module" src="./js/dishList.js"></script>
    <title>Dishes</title>
</head>

<body>
    <nav>
        <div>
            <img src="./img/ccsLogoWhite.png" alt="Cook Code System Logo">
        </div>
        <ul>
            <a href="dashboard.php">
                <li> <object data="./svg/dashboard.svg" type="image/svg+xml"></object>Dashboard</li>
            </a>
            <a href="analytics.php">
                <li> <object data="./svg/graph.svg" type=""></object>Analytics</li>
            </a>
            <a href="stock.php">
                <li> <object data="./svg/stock.svg" type=""></object>Stock</li>
            </a>
            <a href="receipts.php">
                <li> <object data="./svg/receipt.svg" type=""></object>Pre-prepareds</li>
            </a>
          
            <a href="dishes.php"><li> <object data="./svg/receipt.svg" type=""></object>Dishes</li></a>
            <a href="orders.php">
                <li> <object data="./svg/orders.svg" type=""></object>Orders</li>
            </a>
            <a href="tpv.html">
                <li> <object data="./svg/tpv.svg" type=""></object>TPV</li>
            </a>
            <a href="settings.php">
                <li> <object data="./svg/settings.svg" type=""></object>Settings</li>
            </a>
        </ul>
    </nav>

    <main>
        <h2 id="mainTitle">Dishes</h2>
       
        <section id="receipts-container">
          
        <dish-list></dish-list>
         
        </section>
    </main>
</body>

</html>