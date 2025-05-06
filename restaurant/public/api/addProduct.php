<?php 
/* For the stock page, will add ingredients/products to DB */

/* Session validation */
session_start();

/* $_SESSION['isLogged'] = true;
$_SESSION['user_id'] = 1; */

if (!isset($_SESSION['isLogged'])) {
    echo "User not logged!";
    die();
}

$user = $_SESSION['user_id'];

include_once './../../db/autoload.php';

$stock = new Stock;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Obtener el contenido del cuerpo de la solicitud (JSON)
   $jsonData = file_get_contents('php://input');
    
   // Decodificar los datos JSON en un array PHP
   $data = json_decode($jsonData, true);

   // Verificar que los datos del pedido y los productos existan
   if (isset($data['pedido']) && isset($data['productos'])) {

       // Obtener los datos del pedido
       $pedido = $data['pedido'];
       $restaurante_id = $pedido['id_restaurante'] ?? null;

       // Validar que el ID del restaurante esté presente
       if (!$restaurante_id) {
           echo "Error: Falta el ID del restaurante.";
           die();
       }

       // Recorrer los productos del pedido y añadirlos al stock
       foreach ($data['productos'] as $producto) {
           $ingrediente_id = 5 ?? null;  // Usamos SKU como ID del ingrediente
           $cantidad_stock = $producto['cantidad'] ?? null;
           $unidad = "unidad"; // Se puede cambiar según sea necesario
           $precio = 0; // Asigna el precio, si está disponible
           $moneda = "USD"; // Puedes ajustar la moneda según tu aplicación
           $caducidad = $producto['fecha_caducidad'] ?? null;

           // Validar que los datos del producto sean válidos
           if (!$ingrediente_id || !$cantidad_stock || !$caducidad) {
               echo "Error: Faltan datos necesarios para añadir stock del producto.";
               die();
           }

           // Llamar al método addStock de la clase Stock
           $resultado = $stock->addStock($restaurante_id, null, $ingrediente_id, $cantidad_stock, $unidad, $precio, $moneda, $caducidad);

           // Manejar el resultado para cada producto
           if ($resultado) {
               echo "Stock del producto {$producto['nombreProducto']} añadido correctamente.<br>";
           } else {
               echo "Error al añadir el stock del producto {$producto['nombreProducto']}.<br>";
           }
       }

   } else {
       echo "Error: No se recibieron los datos del pedido o de los productos.";
   }
} else {
   echo "Método no permitido. Usa POST.";
}
