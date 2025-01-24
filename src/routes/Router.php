<?php

namespace Src\Routing;

use GuzzleHttp\Psr7\Response;

class Router
{
    private $method;
    private $uri;
    private $controllers;

    public function __construct($method, $uri, array $controllers)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->controllers = $controllers;
    }

    // private function route($path, $id)
    // {
    //     // Extract the controller name from the path (e.g., "products" -> "ProductController")
    //     $controllerName = ucfirst($path) . 'Controller';

    //     // Check if the controller exists in the provided controllers array
    //     if (isset($this->controllers[$controllerName])) {
    //         $controller = $this->controllers[$controllerName];
    //         $controller->processRequest($this->method, $id);
    //     } else {
    //         // Handle 404 Not Found
    //         $response = new Response(
    //             404, 
    //             ['Content-Type' => 'application/json'], 
    //             json_encode(['message' => 'Endpoint not found']));
    //         echo $response->getBody();
    //     }
    // }

    public function run()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
        header('Content-Type: application/json; charset=UTF-8');

        // Prepare path
        $uriParts = explode('/', $this->uri);
        array_shift($uriParts); // Remove the first empty part
        $path = $uriParts[0] ?? null; // Get the path (e.g., "products")
        $id = $uriParts[1] ?? null; // Get the ID (e.g., "123")

        // Route the request
        switch ($path) {
            case 'products':
                $this->controllers['ProductController']->processRequest($this->method , $id );
                break;
            
            default:
            $response = new Response(
                404, 
                ['Content-Type' => 'application/json'], 
                json_encode(['message' => 'Endpoint not found']));
            echo $response->getBody();
                break;
        }
    }
}
?>

<!-- <?php
// require 'vendor/autoload.php';

// require_once __DIR__ . '/../../config/database.php';
// require_once __DIR__ . '/../controllers/ProductController.php';
// require_once __DIR__ . '/../controllers/CartController.php';

// use GuzzleHttp\Psr7\ServerRequest;
// use GuzzleHttp\Psr7\Response;

// $productController = new ProductController($pdo);
// $cartController = new CartController();

// $request = ServerRequest::fromGlobals();

// $requestUri = $request->getUri()->getPath();
// $requestMethod = $request->getMethod();

// switch(true){
//     case $requestUri ==="/products" && $requestMethod === "GET":
//         $response = $productController->getAllProducts();
//         break;
//     case preg_match("/\/product\/(\d+)/" ,$requestUri , $matches  )  && $requestMethod === "GET":
//         $id = $matches[1];
//         $response = $productController->getProductDetails($id);
//         break;

//     case $requestUri === '/cart/add' && $requestMethod === 'POST':
//         $parserBody = $request->getParsedBody();
//         $productId = $parserBody['product_id'] ?? null;
//         $response = $cartController->addToCart($productId);
//         break;

//     case $requestUri === '/cart' && $requestMethod === 'GET':
//         $response = $cartController->viewCart();
//         break;

//     default:
//         // Handle 404 Not Found
//         $response = new Response(404, ['Content-Type' => 'application/json'], json_encode(['message' => 'Endpoint not found']));
//         break;
// }
?> -->

