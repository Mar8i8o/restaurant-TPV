<?php 
include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/db/autoload.php';
session_start();

// Not Logged users:
if(!$_SESSION['isLogged']) {
    $host = $_SERVER['HTTP_HOST'];
    header("Location: http://$host/restaurant/public/login.html");
    die();
}
?>