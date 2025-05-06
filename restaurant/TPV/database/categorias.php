<?php
header('Content-Type: application/json');
include_once('conexion.php');

try {
    $sql = 'SELECT * FROM categorias';
    $stmt = $pdo->query($sql);
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($categorias);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener las categorías']);
}
?>
