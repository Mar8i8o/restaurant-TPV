<?php
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

#[\AllowDynamicProperties]
class Stock {
    function __construct() {
        include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/db/autoload.php';
        $this->db = new Database();
        /* Logger */
        $this->log = new Logger("logger");
        $this->log->pushHandler(new StreamHandler($_SERVER["DOCUMENT_ROOT"] . '/restaurant//AppLog.log'), Level::Warning);
    }

    public function getStockById($id) {
        $sqlSelect = "SELECT * FROM stock WHERE id = :id";
        $stmtSelect = $this->db->conn->prepare($sqlSelect);
        $stmtSelect->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutar la consulta SELECT
        $stmtSelect->execute();
        return $stmtSelect->fetch(PDO::FETCH_ASSOC); 
    }

    public function removeStockById($id) {
        $this->log->info("Removing stock with ID: $id");

        // Primero guardar para log
        $stockData = $this->getStockById($id);

        $sql = "
        DELETE FROM stock WHERE id = :id;
        ";

        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->execute();

        if($result) {
            $this->log->info("Deleted stock with ID: $id");
            $this->log->info("Logging action in [log] table");
        }
    }

    public function getAllStockFromRestaurant($restaurant_id) {
        $this->log->info("Trying to read all stock from restaurant with ID: $restaurant_id");
        
        $sql = "
        SELECT
            stock.id,
            stock.restaurante_id,
            stock.elaborado_id,
            elaborado.nombre AS elaborado_nombre,
            stock.ingrediente_id,
            ingrediente.nombre AS ingrediente_nombre,
            stock.cantidad_stock,
            stock.unidad,
            tipo_unidad.unidad AS tipo_unidad_unidad,
            stock.precio,
            stock.moneda,
            tipo_moneda.Moneda AS tipo_moneda_moneda,
            stock.caducidad
        FROM
            stock
        LEFT JOIN
            elaborado ON stock.elaborado_id = elaborado.elaborado_id
        LEFT JOIN
            ingrediente ON stock.ingrediente_id = ingrediente.ingrediente_id
        LEFT JOIN
            tipo_unidad ON stock.unidad = tipo_unidad.id
        LEFT JOIN
            tipo_moneda ON stock.moneda = tipo_moneda.id
        WHERE
            stock.restaurante_id = :restaurante_id";

        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute(['restaurante_id' => $restaurant_id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->db->close();
        
        return $data;
    }

    public function addStock($restaurante_id, $elaborado_id, $ingrediente_id, $cantidad_stock, $unidad, $precio, $moneda, $caducidad) {
        // Log de inicio
        $this->log->info("Añadiendo nuevo stock para el restaurante con ID: $restaurante_id");
    
        // Verificar si todos los datos necesarios están presentes
        if (empty($restaurante_id) || empty($cantidad_stock) || empty($unidad) || empty($precio) || empty($moneda)) {
            $this->log->error("Faltan datos para añadir stock.");
            return false; // Retornar falso o manejar el error
        }
    
        // Preparar la consulta SQL para insertar
        $sqlInsert = "
        INSERT INTO stock (restaurante_id, elaborado_id, ingrediente_id, cantidad_stock, unidad, precio, moneda, caducidad)
        VALUES (:restaurante_id, :elaborado_id, :ingrediente_id, :cantidad_stock, :unidad, :precio, :moneda, :caducidad)
        ";
    
        // Preparar la ejecución de la consulta
        $stmt = $this->db->conn->prepare($sqlInsert);
    
        // Ligar los parámetros a la consulta SQL
        $stmt->bindParam(':restaurante_id', $restaurante_id, PDO::PARAM_INT);
        $stmt->bindParam(':elaborado_id', $elaborado_id, PDO::PARAM_INT); // Puede ser null si no es obligatorio
        $stmt->bindParam(':ingrediente_id', $ingrediente_id, PDO::PARAM_INT); // Puede ser null si no es obligatorio
        $stmt->bindParam(':cantidad_stock', $cantidad_stock, PDO::PARAM_STR); // FLOAT o DECIMAL según tu BD
        $stmt->bindParam(':unidad', $unidad, PDO::PARAM_INT); // El ID de la unidad de medida
        $stmt->bindParam(':precio', $precio, PDO::PARAM_STR); // FLOAT o DECIMAL según tu BD
        $stmt->bindParam(':moneda', $moneda, PDO::PARAM_INT); // El ID de la moneda
        $stmt->bindParam(':caducidad', $caducidad, PDO::PARAM_STR); // Formato de fecha Y-m-d
    
        // Ejecutar la consulta
        try {
            $stmt->execute();
            $this->log->info("Stock añadido exitosamente para el restaurante con ID: $restaurante_id");
            return true; // Retornar true si la inserción fue exitosa
        } catch (PDOException $e) {
            $this->log->error("Error al añadir stock: " . $e->getMessage());
            return false; // Retornar false en caso de error
        }
    }
    
}