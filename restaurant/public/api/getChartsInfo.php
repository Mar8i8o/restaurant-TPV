<?php

// Comprobar si envía chart
if(!isset($_GET['nombre_grafico'])) {
    http_response_code(400);
    echo json_encode(array('error' => 'Debe proporcionar un nombre de gráfico'));
    exit;
} 

$nombre_grafico = $_GET['nombre_grafico'];
    
$tabla_valida = verificarTabla($nombre_grafico);

if($tabla_valida) {
    $datos_grafico = obtenerDatosDelGrafico($nombre_grafico);
    
    header('Content-Type: application/json');
    echo json_encode($datos_grafico);
    exit;
} else {
    http_response_code(400);
    echo json_encode(array('error' => 'El nombre del gráfico no es válido'));
    exit;
}

function verificarTabla($nombre_grafico) {
    // Lógica de verificación de tabla
}

function obtenerDatosDelGrafico($nombre_grafico) {
    // Lógica de obtención de datos del gráfico
}

?>
