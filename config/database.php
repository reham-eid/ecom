<?php

namespace config;
require_once __DIR__ . '/../vendor/autoload.php'; 

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $host = $_ENV['DB_HOST'] ?? 'localhost';;
        $dbname = $_ENV['DB_NAME']?? 'ecommerce_PHP';
        $user = $_ENV['DB_USER'] ?? 'root'; 
        $pass = $_ENV['DB_PASS'] ?? '';

        try {
            $this->connection = new PDO("mysql:host=$host;port=3308;dbname=$dbname", $user, $pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Database connection successful.\n";
            
        } catch (PDOException $e) {
            http_response_code(500);
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance(){ // The Singleton pattern ensures only one connection is used.
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }

}