<?php

// Load dependencies
require_once __DIR__ . '/vendor/autoload.php';

use GraphQL\Error\DebugFlag;
use config\Database;
use GraphQL\GraphQL;
use src\controllers\ProductController;
use src\controllers\CartController;
use src\repository\ProductRepository;
use src\repository\CartRepository;
use src\routes\Router;
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

// GraphQL endpoint
if ($_SERVER['REQUEST_URI'] === '/graphql' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $schemaPath = __DIR__ . '/src/graphql/schema.php';

    if (!file_exists($schemaPath)) {
        die(json_encode(['errors' => ['message' => "Schema file not found at: $schemaPath"]]));
    }

    $schema = require $schemaPath;

    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die(json_encode(['errors' => ['message' => 'Invalid JSON input.']]));
    }

    $query = $input['query'];
    $variableValues = $input['variables'] ?? null;

    try {
        $debugFlags = ($appEnv === 'development')
            ? DebugFlag::INCLUDE_DEBUG_MESSAGE | DebugFlag::RETHROW_INTERNAL_EXCEPTIONS
            : 0;

        $result = GraphQL::executeQuery($schema, $query, null, null, $variableValues);
        $output = $result->toArray($debugFlags);

    } catch (\Exception $e) {
        $output = [
            'errors' => [
                ['message' => $e->getMessage()],
            ],
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($output);
    exit;
}

// REST API endpoint
$pdo = Database::getInstance();
if (!($pdo instanceof PDO)) {
    die(json_encode(['errors' => ['message' => "Database connection failed."]]));
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

?>
