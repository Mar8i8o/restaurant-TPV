<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $hostRestaurant = "localhost";
    $usernameRestaurant = "root";
    $passwordRestaurant = "";
    $databaseRestaurant = "restaurant";

    $nombre = $_POST['nombre'];
    $instrucciones = $_POST['instrucciones'];

    // Handle the image upload
    $imagen = $_FILES['imagen']['name'];
    $target_dir = "img_dishes/"; // Ensure this directory exists
    $target_file = $target_dir . basename($imagen);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
        // Database connection
        $conn = new mysqli($hostRestaurant, $usernameRestaurant, $passwordRestaurant, $databaseRestaurant);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Start transaction to ensure everything is saved together
        $conn->begin_transaction();

        // Insert the dish into the "platos" table
        $stmt = $conn->prepare("INSERT INTO platos (nombre, imagen, instrucciones) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $target_file, $instrucciones);

        if ($stmt->execute()) {
            // Get the last inserted id for the "plato"
            $id_plato = $conn->insert_id;

            // Insert platos preelaborados
            $platosElaboradosNombres = $_POST['platos_elaborados']['nombre'];
            $platosElaboradosCantidades = $_POST['platos_elaborados']['cantidad'];

            $stmtPreelaborado = $conn->prepare("INSERT INTO platos_preelaborados (id_plato, nombre, cantidad) VALUES (?, ?, ?)");

            for ($i = 0; $i < count($platosElaboradosNombres); $i++) {
                $nombreElaborado = $platosElaboradosNombres[$i];
                $cantidadElaborado = $platosElaboradosCantidades[$i];
                if (!empty($nombreElaborado) && !empty($cantidadElaborado)) {
                    $stmtPreelaborado->bind_param("isd", $id_plato, $nombreElaborado, $cantidadElaborado);
                    $stmtPreelaborado->execute();
                }
            }

            // Insert ingredientes
            $ingredientesNombres = $_POST['ingredientes']['nombre'];
            $ingredientesCantidades = $_POST['ingredientes']['cantidad'];
            $ingredientesUnidades = $_POST['ingredientes']['unidad'];

            $stmtIngrediente = $conn->prepare("INSERT INTO platos_ingrediente (id_plato, nombre, cantidad, unidad) VALUES (?, ?, ?, ?)");

            for ($i = 0; $i < count($ingredientesNombres); $i++) {
                $nombreIngrediente = $ingredientesNombres[$i];
                $cantidadIngrediente = $ingredientesCantidades[$i];
                $unidadIngrediente = $ingredientesUnidades[$i];
                if (!empty($nombreIngrediente) && !empty($cantidadIngrediente) && !empty($unidadIngrediente)) {
                    $stmtIngrediente->bind_param("isds", $id_plato, $nombreIngrediente, $cantidadIngrediente, $unidadIngrediente);
                    $stmtIngrediente->execute();
                }
            }

            // If everything went well, commit the transaction
            $conn->commit();
        } else {
            // Rollback the transaction in case of error
            $conn->rollback();
        }

        // Close statements and connection
        $stmt->close();
        $stmtPreelaborado->close();
        $stmtIngrediente->close();
        $conn->close();
    }
}
?>
