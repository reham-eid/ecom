<?php

/// index.php
require_once __DIR__ . '/vendor/autoload.php';

use config\Database;
use GraphQL\GraphQL;
use src\controllers\ProductController;
use src\controllers\CartController;
use src\repository\ProductRepository;
use src\repository\CartRepository;
use src\routes\Router;

// Handle GraphQL requests
if ($_SERVER['REQUEST_URI'] === '/graphql' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Load the schema
    $schemaPath = __DIR__ . '/graphql/schema.php';
    if (!file_exists($schemaPath)) {
        die("Schema file not found at: $schemaPath");
    }

    $schema = require $schemaPath;

    // Handle the GraphQL request
    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);
    $query = $input['query'];
    $variableValues = isset($input['variables']) ? $input['variables'] : null;

    try {
        $result = GraphQL::executeQuery($schema, $query, null, null, $variableValues);
        $output = $result->toArray();
    } catch (\Exception $e) {
        $output = [
            'errors' => [
                'message' => $e->getMessage(),
            ]
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($output);
    exit;
}

// Handle REST API requests
$pdo = Database::getInstance();

// Debugging: Check the type of $pdo
if (!($pdo instanceof PDO)) {
    die("Invalid PDO object. Check your database configuration.");
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
