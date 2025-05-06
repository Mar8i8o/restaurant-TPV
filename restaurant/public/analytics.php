<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/php/verifyLogged.php';







$host = "localhost";
$username = "root";
$password = "";
$database = "restaurant";

// Attempt to connect to MySQL database
$link = new mysqli($host, $username, $password, $database);

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Analyics</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/analytics.css">
    <!-- ChartsJS -->
    <script defer src="./vendor/nnnick/chartjs/dist/Chart.js"></script>
    <script defer type="module" src="./js/dashboardCharts.js"></script>
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

            <a href="dishes.php">
                <li> <object data="./svg/receipt.svg" type=""></object>Dishes</li>
            </a>
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
        <h2 id="mainTitle">Analytics</h2>

        <section> <!-- ECONOMY -->
            <div class="section-title">
                <object data="./svg/money-bag.svg" type=""></object>
                <h3>Economy</h3>
            </div>
            <hr>
            <div class="section-data">
                <!-- Ingresos, gastos(Pedidos woo), beneficio, desperdicio(Dinero perdido por caducidad o malgastar producto). -->

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
                        <h3>15</h3>
                        <span style="color: red;">+1</span>
                        <select name="" id="">
                        <option value="Semana">Week</option>
                        <option value="Dia">Day</option>
                        <option value="Mes">Month</option>
                        <option value="Año">Year</option>
                        </select>
                    </div>
                    <span>Productos Deshechados</span>
                    <canvas id="chartDeshechados" width="400px" height="300px"></canvas>
                </div>
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
                    <span>Disposed Products</span>
                    <canvas id="chartComprados" width="400px" height="300px"></canvas>
                </div>

                <div class="smallStatsBubble">
                    <div>
                        <h4>15.320 €</h4>
                        <span style="color: red;">-350 €</span>
                    </div>
                    <span>Shopping</span>
                    <select name="" id="">
                    <option value="Semana">Week</option>
                        <option value="Dia">Day</option>
                        <option value="Mes">Month</option>
                        <option value="Año">Year</option>
                    </select>
                    <canvas id="chartCompras" width="400px" height="300px"></canvas>
                </div>
            </div>
        </section>

        <section> <!-- STOCK -->
            <div class="section-title">
                <object data="./svg/box.svg" type=""></object>
                <h3>Stock</h3>
            </div>
            <hr>
            <div class="section-data">
                <div class="smallStatsBubble">
                    <div>
                        <h3>Stock </h3>
                    </div>
                    <canvas id="chartMenosStock" width="400px" height="300px"></canvas>
                </div>

                <div class="bubble" id="table-stockBajo">
                    <h4>Low Stock</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Amount</th>
                            </tr>
                        </thead>

                        <tbody id="body_stock">

                        </tbody>
                    </table>
                </div>

                <div class="bubble" id="table-movimientos">
                    <h4>Recent movements</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Info</th>
                                <th>ID</th>
                                <th>Amount</th>
                                <th>Hour</th>
                            </tr>
                        </thead>
                        <tr>
                            <td style="color: red;">It is spent -</td>
                            <td>#SKU123 Tomates</td>
                            <td>3 Ud</td>
                            <td>24/04/24 - 12:34</td>
                        </tr>
                        <tr>
                            <td style="color: green;">
                            It is added +</td>
                            <td>#SKU323 Producto</td>
                            <td>2 Ud</td>
                            <td>24/04/24 - 11:34</td>
                        </tr>
                        <tr>
                            <td style="color: red;">It is spent -</td>
                            <td>#SKU123 Tomates</td>
                            <td>3 Ud</td>
                            <td>24/04/24 - 12:34</td>
                        </tr>
                        <tr>
                            <td style="color: red;">It is spent -</td>
                            <td>#SKU123 Tomates</td>
                            <td>3 Ud</td>
                            <td>24/04/24 - 12:34</td>
                        </tr>
                    </table>
                </div>
            </div>
        </section>

        <section> <!-- KITCHEN -->
            <div class="section-title">
                <object data="./svg/kitchen.svg" type=""></object>
                <h3>Kitchen</h3>
            </div>
            <hr>
            <div class="section-data">
                <!-- desperdicio, stock con caducidad cercana   -->
                <div class="smallStatsBubble">
                    <div>
                        <h3>Expiration</h3>
                    </div>
                    <canvas id="chartCaducidad" width="350px" height="350px"></canvas>
                </div>
            </div>
        </section>

    </main>
</body>

</html>