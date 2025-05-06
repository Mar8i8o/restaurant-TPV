<?php
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

#[\AllowDynamicProperties]
class Log {
    function __construct() {
        include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/db/autoload.php';
        $this->db = new Database();
        /* Logger */
        $this->logger = new Logger("logger");
        $this->logger->pushHandler(new StreamHandler($_SERVER["DOCUMENT_ROOT"] . '/restaurant//AppLog.log'), Level::Warning);
    }

    public function getStockById($id) {
        $sqlSelect = "SELECT * FROM stock WHERE id = :id";
        $stmtSelect = $this->db->conn->prepare($sqlSelect);
        $stmtSelect->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutar la consulta SELECT
        $stmtSelect->execute();
        return $stmtSelect->fetch(PDO::FETCH_ASSOC); 
    }
}