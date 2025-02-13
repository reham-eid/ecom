<?php
// php -S localhost:8000
// Load dependencies
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/errorHandlers.php';

use GraphQL\Error\DebugFlag;
use Config\Database;
use GraphQL\GraphQL;
use Src\Controllers\ProductController;
use Src\Controllers\CartController;
use Src\Repository\ProductRepository;
use Src\Repository\CartRepository;
use Src\Routes\Router;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Set default environment
$appEnv = $_ENV['APP_ENV'] ?? 'production';

// Enable error reporting in development mode
if ($appEnv === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

try {
    // GraphQL endpoint
    if ($_SERVER['REQUEST_URI'] === '/graphql' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $schemaPath = __DIR__ . '/src/graphql/schema.php';

        if (!file_exists($schemaPath)) {
            http_response_code(500);
            echo json_encode(['errors' => [['message' => "Schema file not found at: $schemaPath"]]]);
            exit;
        }

        $schema = require $schemaPath;
        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['errors' => [['message' => 'Invalid JSON input.']]]);
            exit;
        }

        $query = $input['query'] ?? null;
        $variableValues = $input['variables'] ?? null;

        if (!$query) {
            http_response_code(400);
            echo json_encode(['errors' => [['message' => 'Query parameter is required.']]]);
            exit;
        }

        try {
            $debugFlags = ($appEnv === 'development')
                ? DebugFlag::INCLUDE_DEBUG_MESSAGE | DebugFlag::RETHROW_INTERNAL_EXCEPTIONS
                : 0;

            $result = GraphQL::executeQuery($schema, $query, null, null, $variableValues);
            $output = $result->toArray($debugFlags);

            if (isset($output['errors'])) {
                http_response_code(400); 
            }
        } catch (Exception $e) {
            $output = ['errors' => [['message' => $e->getMessage()]]];
            if (isset($output['errors'])) {
                http_response_code(500);
            }
            echo json_encode($output);
            exit; 
        }

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        // http_response_code(200);
        echo json_encode($output);
        exit;
    }

    // REST API endpoint
    $pdo = Database::getInstance();
    if (!($pdo instanceof PDO)) {
        http_response_code(500);
        echo json_encode(['errors' => [['message' => "Database connection failed."]]]);
        exit;
    }

    $productRepository = new ProductRepository($pdo);
    $cartRepository = new CartRepository($pdo);

    $productController = new ProductController($productRepository);
    $cartController = new CartController($cartRepository);

    $requestUri = $_SERVER['REQUEST_URI'];
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    $router = new Router(
        $requestMethod,
        $requestUri,
        [
            "ProductController" => $productController,
            "CartController" => $cartController
        ]
    );

    $router->run();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'errors' => [
            ['message' => 'Internal Server Error: ' . $e->getMessage()]
            ]
        ]);
    exit;
}

?>