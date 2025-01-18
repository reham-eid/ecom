<!-- <?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../controllers/CartController.php';

$productController = new ProductController($pdo);
$cartController = new CartController();

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/products' && $requestMethod === 'GET') {
    $productController->getAllProducts();
} elseif (preg_match('/\/products\/(\d+)/', $requestUri, $matches) && $requestMethod === 'GET') {
    $productController->getProductDetails($matches[1]);
} elseif ($requestUri === '/cart/add' && $requestMethod === 'POST') {
    $productId = $_POST['product_id'];
    $cartController->addToCart($productId);
} elseif ($requestUri === '/cart' && $requestMethod === 'GET') {
    $cartController->viewCart();
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint not found']);
}

?> -->

<?php
require 'vendor/autoload.php';

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../controllers/CartController.php';

use GuzzleHttp\Psr7\ServerRequest;
use GuzzleHttp\Psr7\Response;

$productController = new ProductController($pdo);
$cartController = new CartController();

$request = ServerRequest::fromGlobals();

$requestUri = $request->getUri()->getPath();
$requestMethod = $request->getMethod();

switch(true){
    case $requestUri ==="/products" && $requestMethod === "GET":
        $response = $productController->getAllProducts();
        break;
    case preg_match("/\/product\/(\d+)/" ,$requestUri , $matches  )  && $requestMethod === "GET":
        $id = $matches[1];
        $response = $productController->getProductDetails($id);
        break;

    case $requestUri === '/cart/add' && $requestMethod === 'POST':
        $parserBody = $request->getParsedBody();
        $productId = $parserBody['product_id'] ?? null;
        $response = $cartController->addToCart($productId);
        break;

    case $requestUri === '/cart' && $requestMethod === 'GET':
        $response = $cartController->viewCart();
        break;

    default:
        // Handle 404 Not Found
        $response = new Response(404, ['Content-Type' => 'application/json'], json_encode(['message' => 'Endpoint not found']));
        break;
}