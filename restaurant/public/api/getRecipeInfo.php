<?php

/* VALIDATIONS */
session_start();

if (!isset($_SESSION['isLogged'])) {
    echo "User not logged!";
    die();
}

if(!isset($_GET['recipe_id'])) {
    http_response_code(400);
    echo json_encode(array('message' => 'Recipe ID is required'));
    die();
}

/* -------------------- */

include_once '/xampp/htdocs/db/autoload.php';

$recipe_id = $_GET['recipe_id'];
$user = $_SESSION['user_id'];

$recetaMng = new Receta;
$recipe = $recetaMng->getRecetaById($recipe_id);

if($recipe) {
    header('Content-Type: application/json');
    echo json_encode($recipe);
} else {
    http_response_code(404);
    echo json_encode(array('message' => 'Recipe not found'));
}

die();