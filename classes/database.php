<?php
// Version simple du Singleton pour la connexion PDO
class Database {
    private static $instance = null;
    private $conn;

    private $host = "localhost";
    private $db_name = "mabagnole";
    private $username = "root";
    private $password = "";

    private function __construct() {
        $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>