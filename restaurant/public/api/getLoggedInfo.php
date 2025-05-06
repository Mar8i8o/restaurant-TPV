<?php 
/* INFO
    · Returns JSON with user info, for UI things
*/

/* - Session validation & Includes ---------------------------------- */
session_start();

if (!isset($_SESSION['isLogged'])) {
    echo "User not logged!";
    die();
}

$user = $_SESSION['loggedUserName'];

$data = array(
    "username" => $_SESSION['loggedUserName'], 
    "restaurant" => $_SESSION['loggedRestaurant'],
);

header("Content-Type: application/json");
echo json_encode($data);
/* ------------------------------------------------------------------- */