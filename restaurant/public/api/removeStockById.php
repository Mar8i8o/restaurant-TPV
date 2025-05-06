<?php
$postdata = file_get_contents("php://input");
$post = json_decode($postdata, true);

/* - Access validation ---------------------------------- */
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo "Access denied";
    exit();
}

if (!isset($post['restaurant_id'])) {
    echo json_encode(["error" => "restaurant_id not sent"]);
    exit();
}

/* ------------------------------------------------------- */

include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/db/autoload.php';
$stock = new Stock();
try {
    $users = $db->read("usuario", "restaurante_id = " . $post['restaurant_id']);
    echo json_encode($users);
} catch (\Throwable $th) {
    //throw $th;
}