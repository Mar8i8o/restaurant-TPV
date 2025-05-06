<?php 
    include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/php/verifyLogged.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/dashboard.css">
    <!-- ChartsJS -->
    <script defer type="module" src="./vendor/nnnick/chartjs/dist/Chart.js"></script>
    <script defer type="module" src="./js/dashboardCharts.js"></script>
    <script defer type="module" src="./js/dashboard.js"></script>

</head>
<body>
    <nav>
        <div>
            <img src="./img/ccsLogoWhite.png" alt="Cook Code System Logo">
            <button>III</button>
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
        
        <div id="header">
            <h2 id="mainTitle">Dashboard</h2>
            <div id="userBubble">
                <img src="./img/test.jpg" alt="">
                <h4 class="user_data-username">Not logged</h3>
                <span>···</span>
            </div>
        </div>
        <section class="smallStatsContainer">
            <div class="smallStatsBubble">
                <div>
                    <h3>304</h3>
                    <span>+34</span>
                    <select name="" id="">
                        <option value="Semana">Week</option>
                        <option value="Dia">Day</option>
                        <option value="Mes">Month</option>
                        <option value="Año">Year</option>
                    </select>
                </div>
                <span>Products sold</span>
                <canvas id="chartVendidos" width="400px" height="300px"></canvas>
            </div>

            <div class="smallStatsBubble">
                <div>
                    <h4>15.320 €</h4>
                    <span style="color: red;">-350 €</span>
                </div>
                <span>Sales</span>
                <select name="" id="">
                    <option value="Semana">Week</option>
                    <option value="Dia">Day</option>
                    <option value="Mes">Month</option>
                    <option value="Año">Year</option>
                </select>
                <canvas id="chartVentas" width="400px" height="300px"></canvas>
            </div>

            <div class="smallStatsBubble">
                <div>
                    <h3>Low Stock</h3>
                </div>
                <canvas id="chartMenosStock" width="400px" height="300px"></canvas>
            </div>

            <div class="smallStatsBubble">
                <div>
                    <h3>15</h3>
                    <span style="color: red;">+1</span>
                    <select name="" id="">
                        <option value="Semana">Week</option>
                        <option value="Dia">Day</option>
                        <option value="Mes">Month</option>
                        <option value="Año">Year</option>
                    </select>
                </div>
                <span>Disposed Products</span>
                <canvas id="chartDeshechados" width="400px" height="300px"></canvas>
            </div>
        </section>

        <section class="bigStatsContainer">
            <div class="bigStatsBubble">
                <div>
                    <h3>Best selling products</h3>
                    <select name="" id="">
                        <option value="Semana">Week</option>
                        <option value="Dia">Day</option>
                        <option value="Mes">Month</option>
                        <option value="Año">Year</option>
                    </select>
                </div>
                <canvas id="chartMasVendidos" width="350px" height="350px"></canvas>
            </div>
            <div class="bigStatsBubble">
                <div>
                    <h3>Expiration</h3>
                </div>
                <canvas id="chartCaducidad" width="350px" height="350px"></canvas>
            </div>
        </section>
    </main>
</body>
</html>