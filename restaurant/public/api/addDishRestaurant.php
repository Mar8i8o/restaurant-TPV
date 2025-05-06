<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "restaurant";

// Intento de conexión a la base de datos MySQL
$link = new mysqli($host, $username, $password, $database);

$response = [
    'error' => false,
    'message' => '',
    'success' => ''
];

// Verificar la conexión
if ($link->connect_error) {
    $response = [
        'error' => true,
        'message' => "Connection failed: " . $link->connect_error
    ];
    http_response_code(500);
    echo json_encode($response);
    exit;
}

// Verificar si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el contenido del cuerpo de la solicitud (JSON)
    $jsonData = file_get_contents('php://input');
    
    // Decodificar los datos JSON en un array PHP
    $data = json_decode($jsonData, true);
    
    // Obtener el ID del plato y el array de IDs de restaurantes desde el JSON recibido
    $id_plato = $data['platoId'];
    $restaurantes = $data['restaurantes']; // Array de IDs de restaurantes
    
    // Iniciar transacción para insertar o actualizar múltiples registros en la tabla plato_restaurante
    $link->begin_transaction();
    
    try {
        // Insertar o actualizar cada restaurante asociado al plato
        foreach ($restaurantes as $id_restaurante) {
            // Verificar si ya existe la fila con id_plato y id_restaurante
            $checkQuery = "SELECT id_plato FROM plato_restaurante WHERE id_plato = ? AND id_restaurante = ?";
            $checkStmt = $link->prepare($checkQuery);
            $checkStmt->bind_param("ii", $id_plato, $id_restaurante);
            $checkStmt->execute();
            $checkStmt->store_result();
            
            if ($checkStmt->num_rows > 0) {
                // Si ya existe, actualizar el campo 'activo' a 1
                $updateQuery = "UPDATE plato_restaurante SET activo = 1 WHERE id_plato = ? AND id_restaurante = ?";
                $updateStmt = $link->prepare($updateQuery);
                $updateStmt->bind_param("ii", $id_plato, $id_restaurante);
                
                if (!$updateStmt->execute()) {
                    throw new Exception("Error al actualizar la asignación: " . $updateStmt->error);
                }
            } else {
                // Si no existe, insertar la nueva fila con 'activo' en 1
                $insertQuery = "INSERT INTO plato_restaurante (id_plato, id_restaurante, activo) VALUES (?, ?, 1)";
                $insertStmt = $link->prepare($insertQuery);
                $insertStmt->bind_param("ii", $id_plato, $id_restaurante);
                
                if (!$insertStmt->execute()) {
                    throw new Exception("Error al guardar la asignación: " . $insertStmt->error);
                }
            }
        }

        // Ahora actualizar las filas restantes que no están en el array de restaurantes, poner 'activo' a 0
        $ids_restaurantes_str = implode(",", array_map('intval', $restaurantes)); // Convertir el array de IDs a una lista separada por comas
        
        // Solo actualizar los restaurantes que no estén en la lista recibida en el POST
        $updateRemainingQuery = "UPDATE plato_restaurante SET activo = 0 WHERE id_plato = ? AND id_restaurante NOT IN ($ids_restaurantes_str)";
        $updateRemainingStmt = $link->prepare($updateRemainingQuery);
        $updateRemainingStmt->bind_param("i", $id_plato);

        if (!$updateRemainingStmt->execute()) {
            throw new Exception("Error al desactivar las asignaciones restantes: " . $updateRemainingStmt->error);
        }
        
        // Confirmar la transacción
        $link->commit();
        $response['success'] = "Plato asignado o actualizado exitosamente en los restaurantes. Las filas restantes se desactivaron.";
        http_response_code(201); // Código de respuesta 201: Creado
        
    } catch (Exception $e) {
        // Si ocurre un error, revertir la transacción
        $link->rollback();
        $response['error'] = true;
        $response['message'] = $e->getMessage();
        http_response_code(500); // Error interno del servidor
    }
    
} else {
    $response['error'] = true;
    $response['message'] = "Método no permitido. Usa POST.";
    http_response_code(405); // Método no permitido
}

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
exit;

?>
