<?php
require_once 'funciones.php';
// Almacenar este archivo con 0600
class DBConnection {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        // Obtener las credenciales de la base de datos desde un archivo ini
        $config = parse_ini_file('../../../../../config/constructora/y1u8zv4k3q6r2o9.ini');

        // Obtener los valores de las credenciales desde el archivo ini
        $host = $config['host'];
        $database = $config['database'];
        $user = $config['user'];
        $password = $config['password'];

        // Construir la cadena de conexión DSN utilizando los valores de las credenciales
        $dsn = "mysql:host={$host};dbname={$database};charset=utf8mb4";

        // Definir algunas opciones para la conexión PDO
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lanzar excepciones en caso de error
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Devolver resultados como matriz asociativa
            PDO::ATTR_EMULATE_PREPARES => false, // No emular consultas preparadas
        ];

        // Crear un objeto PDO que se utilizará para interactuar con la base de datos
        $this->pdo = new PDO($dsn, $user, $password, $options);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new DBConnection();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }

    public function closeConnection() {
        $this->pdo = null;
    }
}