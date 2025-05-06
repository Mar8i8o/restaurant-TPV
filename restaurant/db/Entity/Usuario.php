<?php
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

#[\AllowDynamicProperties]
class Usuario {
    function __construct() {
        include_once $_SERVER["DOCUMENT_ROOT"] . '/restaurant/db/autoload.php';
        $this->db = new Database();
        session_start();
        /* Logger */
        $this->log = new Logger("logger");
        $this->log->pushHandler(new StreamHandler($_SERVER["DOCUMENT_ROOT"] . '/restaurant/AppLog.log'), Level::Warning);
    }

    public function create($name, $password, $typeOfUser, $restaurant) {
        $this->log->info("Trying to create user $name");

        $password = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'Nombre' => $name,
            'tipo_usuario_id' => $typeOfUser,
            'password' => $password,
            'restaurante_id' => $restaurant
        ];

        try {
            $this->db->create('usuario', $data);
        } catch (Exception $e) {
            echo "Couldn't create user: $e";
        }
    }

    public function read($userId) {
        $this->log->info("Fetching data from user: [$userId]");
        $userInfo = $this->db->read('usuario', 'usuario_id =' . $userId);
        if(!$userInfo) {
            return false;
        }
        return $userInfo;
    }

    public function login($restaurant, $user, $password) {
        $this->log->info("Trying to login to user [$user]");
        session_unset();

        $userInfo = $this->db->read('usuario', 'nombre = "' . strval($user) . '" AND restaurante_id = ' . $restaurant);  // ????
        $userInfo = $userInfo[0]; // Db returns [[userinfo]]

        if(password_verify($password, $userInfo['password'])) {
            $_SESSION['isLogged'] = true;
            $_SESSION['loggedUserId'] = $userInfo['usuario_id'];
            $_SESSION['loggedUserName'] = $userInfo['nombre'];
            $_SESSION['loggedRestaurant'] = $restaurant;

            $this->log->info("User [$user] logged in");
            return true;
        } else {
            $this->log->alert("User [$user] login FAILED");
            echo "Login error: Wrong credentials";
            return false;
        }
    }

    public function adminLogin($restaurant) {
        $this->log->info("Admin access to restaurant[$restaurant]");
        session_unset();
        $_SESSION['isLogged'] = true;
        $_SESSION['loggedRestaurant'] = $restaurant;
        $_SESSION['loggedUserId'] = 0;
        $_SESSION['loggedUserName'] = 'Admin';

        return true;
    }
}