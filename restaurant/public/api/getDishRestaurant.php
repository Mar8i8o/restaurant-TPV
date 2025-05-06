<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "restaurant";

// Conexión a la base de datos
$link = new mysqli($host, $username, $password, $database);

// Verificar la conexión
if ($link->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la conexión con la base de datos']);
    exit;
}

// Consultar todas las recetas
$query = "SELECT * FROM plato_restaurante";
$result = $link->query($query);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    $dishRestaurant = [];
    while ($row = $result->fetch_assoc()) {
        $dishRestaurant[] = $row;
    }
    echo json_encode($dishRestaurant); // Enviar todos los plato_restaurante como un array JSON
} else {
    echo json_encode([]); // Si no hay plato_restaurante, devolver un array vacío
}

$link->close();
?>
