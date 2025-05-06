<?php
include 'database/conexion.php'; // Incluye la conexión para probarla

if ($conn) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error al conectar a la base de datos.";
}

// Cierra la conexión
$conn->close();
?>
