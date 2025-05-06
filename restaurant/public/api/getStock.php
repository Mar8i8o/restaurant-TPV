<?php
$postdata = file_get_contents("php://input");
$post = json_decode($postdata, true);

/* - Access validation ---------------------------------- */
include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/php/verifyLogged.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo "Access denied";
    exit();
}
/* ------------------------------------------------------- */

include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/db/autoload.php';

$stock = new Stock();


// Obtiene el stock del restaurante especificado
$allStock = $stock->getAllStockFromRestaurant($post['restaurant_id']);

// Devuelve los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($allStock);



exit();
