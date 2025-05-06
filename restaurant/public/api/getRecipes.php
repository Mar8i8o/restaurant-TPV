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
$query = "SELECT * FROM receta";
$result = $link->query($query);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    $recipes = [];
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
    echo json_encode($recipes); // Enviar todas las recetas como un array JSON
} else {
    echo json_encode([]); // Si no hay recetas, devolver un array vacío
}

$link->close();
?>
