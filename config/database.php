<?php

namespace Config;
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

        echo $host . "<br>";
        echo $dbname . "<br>";
        echo $user . "<br>";
        echo $pass . "<br>";
        try {
            $this->connection = new PDO("mysql:host=$host;port=3308;dbname=$dbname", $user, $pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
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