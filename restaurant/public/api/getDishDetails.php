<?php
$host = 'localhost';
$db = 'restaurant';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_plato = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_plato > 0) {
    // Obtener detalles del plato
    $dish_query = "SELECT nombre, instrucciones, imagen FROM platos WHERE id = ?";
    $stmt = $conn->prepare($dish_query);
    $stmt->bind_param("i", $id_plato);
    $stmt->execute();
    $dish_result = $stmt->get_result();
    
    if ($dish_result->num_rows > 0) {
        $dish_details = $dish_result->fetch_assoc();

        // Obtener ingredientes
        $ingredients_query = "SELECT nombre, cantidad, unidad FROM platos_ingrediente WHERE id_plato = ?";
        $stmt = $conn->prepare($ingredients_query);
        $stmt->bind_param("i", $id_plato);
        $stmt->execute();
        $ingredients_result = $stmt->get_result();

        $ingredients = [];
        while ($row = $ingredients_result->fetch_assoc()) {
            $ingredients[] = $row;
        }

        // Obtener platos elaborados
        $pre_elaborados_query = "SELECT nombre, cantidad FROM platos_preelaborados WHERE id_plato = ?";
        $stmt = $conn->prepare($pre_elaborados_query);
        $stmt->bind_param("i", $id_plato);
        $stmt->execute();
        $pre_elaborados_result = $stmt->get_result();

        $pre_elaborados = [];
        while ($row = $pre_elaborados_result->fetch_assoc()) {
            $pre_elaborados[] = $row;
        }

        // Retornar datos
        echo json_encode([
            'dish' => $dish_details,
            'ingredients' => $ingredients,
            'pre_elaborados' => $pre_elaborados,
        ]);
    } else {
        echo json_encode(['error' => 'Dish not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid dish ID']);
}

$stmt->close();
$conn->close();
?>
