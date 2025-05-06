<?php
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

#[\AllowDynamicProperties]
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'restaurant';
    public $conn;

    public function __construct() {
            /* Logger */
            $this->log = new Logger("logger");
            $this->log->pushHandler(new StreamHandler($_SERVER["DOCUMENT_ROOT"] . 'restaurant/AppLog.log'), Level::Warning);

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            $this->log->alert($e->getMessage());
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function create($table, $data) {
        // $data is an associative array containing data to be inserted into the database

        $keys = implode(',', array_keys($data));
        $values = implode(',', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($keys) VALUES ($values)";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute(array_values($data));
    }

    public function read($table, $conditions = '') {
        // $conditions (optional) is a string containing SQL conditions for filtering results

        $sql = "SELECT * FROM $table";
        if (!empty($conditions)) {
            $sql .= " WHERE $conditions";
        }
        
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($table, $data, $conditions = '') {
        // $data is an associative array containing data to be updated
        // $conditions (optional) is a string containing SQL conditions for filtering which rows to update

        $setClause = implode('=?, ', array_keys($data)) . '=?';
        $sql = "UPDATE $table SET $setClause";
        if (!empty($conditions)) {
            $sql .= " WHERE $conditions";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array_values($data));
    }

    public function delete($table, $conditions = '') {
        // $table is the name of the table to delete from
        // $conditions (optional) is a string containing SQL conditions for filtering which rows to delete

        $sql = "DELETE FROM $table";
        if (!empty($conditions)) {
            $sql .= " WHERE $conditions";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    }

    public function close() {
        $this->conn = null;
    }

    // ------------

    public function readStockIgredientesForUser($userId) {
        $sql = "SELECT stock.*, ingrediente.Nombre AS Nombre, tipo_unidad.unidad AS Unidad, tipo_moneda.simbolo AS Moneda
                FROM stock 
                INNER JOIN ingrediente ON stock.ingrediente_id = ingrediente.ingrediente_id
                INNER JOIN tipo_unidad ON stock.unidad = tipo_unidad.id
                INNER JOIN tipo_moneda ON stock.moneda = tipo_moneda.id
                WHERE stock.usuario_id = :userId";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readStockElaboradosForUser($userId) {
        $sql = "SELECT stock.*, elaborado.Nombre AS Nombre, tipo_unidad.unidad AS Unidad, tipo_moneda.simbolo AS Moneda
                FROM stock 
                INNER JOIN elaborado ON stock.elaborado_id = elaborado.elaborado_id
                INNER JOIN tipo_unidad ON stock.unidad = tipo_unidad.id
                INNER JOIN tipo_moneda ON stock.moneda = tipo_moneda.id
                WHERE stock.usuario_id = :userId";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
