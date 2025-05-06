<?php
$post = $_POST;

/* - Access validation ---------------------------------- */
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo "Access denied";
    exit();
}
if (!isset($post['user_id']) || !isset($post['user_password'])) {
    echo "user_id or user_password not specified";
    exit();
}

/* ------------------------------------------------------- */

include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/db/autoload.php';
$user = new Usuario();


// User info validation & logIn
$restaurant = $post['restaurant_id'];
$username = $post['user_id'];
$password = $post['user_password'];


if ($user->login($restaurant, $username, $password)) {
    header('Location: ../dashboard.php');
}


