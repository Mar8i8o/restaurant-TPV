<?php
// Datos de conexión
$host = 'localhost';      // Host de la base de datos
$dbname = 'restaurant';   // Nombre de la base de datos
$username = 'root';       // Usuario de la base de datos
$password = '';           // Contraseña de la base de datos

try {
    // Establecer la conexión usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configurar PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Si todo está bien, la conexión se realiza correctamente
} catch (PDOException $e) {
    // En caso de error de conexión, mostrar un mensaje
    echo "Error de conexión: " . $e->getMessage();
    die();  // Detenemos la ejecución
}
?>
