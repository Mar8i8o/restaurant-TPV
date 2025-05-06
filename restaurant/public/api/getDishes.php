<?php
session_start();

if (!isset($_SESSION['isLogged'])) {
    echo json_encode(["error" => "User not logged!"]);
    exit();
}
if (!isset($_GET['restaurant_id'])) {
    echo json_encode(["error" => "Restaurant ID is required"]);
    exit();
}

$restaurantId = intval($_GET['restaurant_id']); // Convertir a número por seguridad

header('Content-Type: application/json');

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Consulta para obtener los IDs de los platos activos del restaurante
$sql2 = "SELECT id_plato FROM plato_restaurante WHERE id_restaurante = ? AND activo = 1";
$stmt2 = $conn->prepare($sql2);

if (!$stmt2) {
    echo json_encode(["error" => "Error preparing statement: " . $conn->error]);
    $conn->close();
    exit();
}

$stmt2->bind_param("i", $restaurantId);
$stmt2->execute();
$result2 = $stmt2->get_result();

$platosRestaurantes = [];
while ($row2 = $result2->fetch_assoc()) {
    $platosRestaurantes[] = $row2['id_plato'];
}

$stmt2->close();

// Verifica si no hay platos para este restaurante
if (empty($platosRestaurantes)) {
    echo json_encode(["error" => "No plato_restaurante found"]);
    $conn->close();
    exit();
}

// Convertir el array de IDs en una cadena separada por comas para la consulta
$platoIdsString = implode(',', $platosRestaurantes);

// Consulta para obtener los detalles de los platos
$sql = "SELECT id, nombre, imagen, instrucciones FROM platos WHERE id IN ($platoIdsString)";
$result = $conn->query($sql);

$dishes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dish = $row;

        // Obtener los ingredientes del plato
        $ingredientSql = "SELECT nombre, cantidad, unidad FROM platos_ingrediente WHERE id_plato = ?";
        $stmt3 = $conn->prepare($ingredientSql);
        $stmt3->bind_param("i", $dish['id']);
        $stmt3->execute();
        $ingredientResult = $stmt3->get_result();
        
        $ingredients = [];
        while ($ingredientRow = $ingredientResult->fetch_assoc()) {
            $ingredients[] = $ingredientRow;
        }
        $stmt3->close();

        // Obtener los preelaborados del plato
        $preelaboradosSql = "SELECT nombre, cantidad FROM platos_preelaborados WHERE id_plato = ?";
        $stmt4 = $conn->prepare($preelaboradosSql);
        $stmt4->bind_param("i", $dish['id']);
        $stmt4->execute();
        $preelaboradosResult = $stmt4->get_result();
        
        $preelaborados = [];
        while ($preelaboradoRow = $preelaboradosResult->fetch_assoc()) {
            $preelaborados[] = $preelaboradoRow;
        }
        $stmt4->close();

        // Agregar los ingredientes y preelaborados al plato
        $dish['ingredients'] = $ingredients;
        $dish['pre_elaborados'] = $preelaborados;

        // Agregar el plato al array de resultados
        $dishes[] = $dish;
    }
} else {
    echo json_encode(["error" => "No dishes found"]);
    $conn->close();
    exit();
}

$conn->close();

// Devolver el array de platos como JSON
echo json_encode($dishes);
?>
