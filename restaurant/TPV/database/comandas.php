<?php
require_once 'conexion.php';  // Asegúrate de que la conexión esté correcta

// Verifica si es una solicitud GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['mesa'])) {
        $mesa = $_GET['mesa'];
        
        // Prepara la consulta para obtener las comandas de la mesa
        $stmt = $pdo->prepare("SELECT * FROM comandas WHERE mesa_id = ?");
        $stmt->execute([$mesa]);
        $comandas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Retorna las comandas en formato JSON
        echo json_encode($comandas);  // Esto debe devolver un array
    } else {
        echo json_encode(['error' => 'Mesa no especificada']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si la solicitud es POST, procesamos la inserción o actualización de la comanda
    $data = json_decode(file_get_contents('php://input'), true);

    // Verificamos que los datos necesarios estén presentes
    if (isset($data['mesa'], $data['producto_id'], $data['cantidad'])) {
        $mesa = $data['mesa'];
        $producto_id = $data['producto_id'];
        $cantidad = $data['cantidad'];

        // Verificamos si ya existe una comanda para esta mesa y producto
        $stmt = $pdo->prepare("SELECT * FROM comandas WHERE mesa_id = ? AND producto_id = ?");
        $stmt->execute([$mesa, $producto_id]);
        $comanda = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($comanda) {
            // Si ya existe, simplemente actualizamos la cantidad
            $nuevaCantidad = $cantidad;  // Solo actualiza la cantidad
            $stmt = $pdo->prepare("UPDATE comandas SET cantidad = ? WHERE id = ?");
            $stmt->execute([$nuevaCantidad, $comanda['id']]);
        } else {
            // Si no existe, insertamos un nuevo producto en la comanda
            $stmt = $pdo->prepare("INSERT INTO comandas (mesa_id, producto_id, cantidad) VALUES (?, ?, ?)");
            $stmt->execute([$mesa, $producto_id, $cantidad]);
        }

        // Respondemos con éxito
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Datos incompletos']);  // Si faltan datos
    }
} else {
    // Si el método no es ni GET ni POST
    echo json_encode(['error' => 'Método no soportado']);
}
?>
