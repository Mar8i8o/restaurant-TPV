<?php
// Incluir el archivo de conexión
include_once('conexion.php');  // Asegúrate de que la ruta es correcta

// Realizar la consulta a la base de datos
try {
    // Realizar la consulta para obtener las mesas
    $sql = 'SELECT * FROM mesas';  
    $stmt = $pdo->query($sql);  // Usamos $pdo para hacer la consulta

    // Obtener todos los resultados
    $mesas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver las mesas como un JSON
    echo json_encode($mesas);

} catch (PDOException $e) {
    // En caso de error, enviar un mensaje de error
    echo json_encode(['error' => 'Error al obtener las mesas']);
}
?>
