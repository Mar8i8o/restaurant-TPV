<?php
// Incluir el archivo de platos.php directamente, para probar su funcionamiento
include 'database/platos.php';  // Esto invoca platos.php

// Comprobamos si los datos han llegado correctamente
if (isset($platos)) {
    echo "Consulta exitosa a los platos:<br>";
    
    // Mostrar los platos obtenidos de la base de datos
    foreach ($platos as $plato) {
        echo "ID: " . $plato["id"] . " - Nombre: " . $plato["nombre"] . "<br>";
    }
} else {
    echo "Error al obtener los platos.";
}
?>
