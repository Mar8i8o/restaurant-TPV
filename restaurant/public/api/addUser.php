<?php
$postdata = file_get_contents("php://input");
$post = json_decode($postdata, true);

/* - Access validation ---------------------------------- */
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo "Access denied";
    exit();
}

if (!isset($post['user_name']) || !isset($post['user_password'])) {
    echo json_encode(["error" => "user_name, user_password or user_type not specified"]);
    exit();
}

/* ------------------------------------------------------- */

include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/db/autoload.php';
$user = new Usuario();

try {
    $user->create($post['user_name'], $post['user_password'], $post['user_type'], $post['user_restaurant']);
    echo json_encode(["ok" => ""]);
} catch (\Throwable $th) {
    //throw $th;
}