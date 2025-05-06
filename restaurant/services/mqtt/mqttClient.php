<?php 
declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';
use \PhpMqtt\Client\MqttClient;
use \PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Exceptions\MqttClientException;


$server   = 'ub181181.ala.eu-central-1.emqxsl.com';
$port     = 8883;
$clientId = 'testPhp';
$username = 'ccs';
$password = 'ccs';
$clean_session = true;
$mqtt_version = MqttClient::MQTT_3_1_1;

printf("Trying to connect\n");
$connectionSettings = (new ConnectionSettings)
  ->setUsername($username)
  ->setPassword($password)
  ->setKeepAliveInterval(60)
  ->setLastWillTopic('emqx/test/last-will')
  ->setLastWillMessage('client disconnect')
  ->setUseTls(true)
  ->setLastWillQualityOfService(2);

try {
    $mqtt = new MqttClient($server, $port, $clientId, $mqtt_version);
    
    $mqtt->connect($connectionSettings, $clean_session);
    printf("client connected\n");
    
    $mqtt->subscribe('emqx/test', function ($topic, $message) {
/*         $db = new Database; */
        printf("Received message on topic [%s]: %s\n", $topic, $message);
/*         $messDeco = json_decode($message);
        $stmt = $db->conn->prepare("INSERT INTO log (ID, restaurante_id, tipo_accion, tipo_tabla, registro_id, cantidad, comentario)
                                VALUES (null, :restaurante_id, :tipo_accion, :tipo_tabla, :registro_id, :cantidad, :comentario)");
        $stmt->execute([
            'restaurante_id' => $messDeco->restaurante_id,
            'tipo_accion' => $messDeco->tipo_accion,
            'tipo_tabla' => $messDeco->tipo_tabla,
            'registro_id' => 1,
            'cantidad' => $messDeco->cantidad,
            'comentario' => "Test"
        ]);

        printf("Message:" . $message . "Sent"); */
    }, MqttClient::QOS_AT_LEAST_ONCE);
    
    $mqtt->loop(true);
} catch (Error $e) {
    printf("Error: " . $e);
}
