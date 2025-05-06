<?php
$postdata = file_get_contents("php://input");
$post = json_decode($postdata, true);

/* - Access validation ---------------------------------- */
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo "Access denied";
    exit();
}
/* ------------------------------------------------------- */

include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/db/autoload.php';
$user = new Usuario();

// Admin direct access
if ($post['isAdmin']) {
    $redirectUrl = "/restaurant/public/dashboard.php";

    $user->adminLogin($post['restaurant_id']);

    echo json_encode(["redirectUrl" => $redirectUrl]);
    exit();
}
exit();
