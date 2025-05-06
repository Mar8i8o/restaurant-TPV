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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Obtener el contenido del cuerpo de la solicitud (JSON)
   $jsonData = file_get_contents('php://input');
    
   // Decodificar los datos JSON en un array PHP
   $data = json_decode($jsonData, true);
/** 
   // Verificar que los datos del pedido y los productos existan
   if (isset($data['pedido']) && isset($data['productos'])) {

    
       // Obtener los datos del pedido
       $pedido = $data['pedido'];
       $restaurante_id = $pedido['id_restaurante'] ?? null;

       // Validar que el ID del restaurante esté presente
       if (!$restaurante_id) {
           $response['error'] = true;
           $response['message'] = "Error: Falta el ID del restaurante.";
           http_response_code(400);
           echo json_encode($response);
           exit;
       }

       // Recorrer los productos del pedido y añadirlos al stock
       foreach ($data['productos'] as $producto) {
           $ingrediente_id = 5 ?? null; // Usamos SKU como ID del ingrediente
           $cantidad_stock = $producto['cantidad'] ?? null;
           $unidad = 1; // Se puede cambiar según sea necesario
           $precio = 0; // Asigna el precio, si está disponible
           $moneda = 1; // Puedes ajustar la moneda según tu aplicación
           $caducidad = $producto['fecha_caducidad'] ?? null;

           // Validar que los datos del producto sean válidos
           if (!$ingrediente_id || !$cantidad_stock || !$caducidad) {
               $response['error'] = true;
               $response['message'] = "Error: Faltan datos necesarios para añadir stock del producto {$producto['nombreProducto']}.";
               http_response_code(400);
               echo json_encode($response);
               exit;
           }

           // Insertar cada producto en una tabla de productos del pedido
           $sql_producto = "INSERT INTO stock (id, restaurante_id, elaborado_id, ingrediente_id, cantidad_stock, unidad, precio, moneda, caducidad)
           VALUES (null,1, null, 2, 5, 1, 12, 1, null)";

           // Ejecutar la consulta y manejar el resultado
           if ($link->query($sql_producto) === TRUE) {
               $response['success'] = "Producto {$producto['nombreProducto']} guardado exitosamente.";
           } else {
               $response['error'] = true;
               $response['message'] = "Error al guardar el producto {$producto['nombreProducto']}: " . $link->error;
           }
       }

       // Si todos los productos se guardaron sin errores
       if (!$response['error']) {
           $response['message'] = "Todos los productos añadidos correctamente.";
       }
   } else {
       $response['error'] = true;
       $response['message'] = "Error: No se recibieron los datos del pedido o de los productos.";
       http_response_code(400);
   }
*/
} else {
   $response['error'] = true;
   $response['message'] = "Método no permitido. Usa POST.";
   http_response_code(405);
}
$response['success'] = "Producto  guardado exitosamente.";
header('Content-Type: application/json');
echo json_encode($response);
http_response_code(200);
exit;
