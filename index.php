<?php

require_once __DIR__ . '/vendor/autoload.php';

use GraphQL\GraphQL;
use GraphQL\Type\Schema;

// Load the schema
$schema = require __DIR__ . '/graphql/schema.php';
// Handle the GraphQL request
$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput , true);
$query = $input['query'] ;
$variableValues  = isset($input['variables']) ? $input['variables'] : null;

try{
  $result = GraphQL::executeQuery($schema, $query , null,null , $variableValues);
  $output = $result->toArray();
}catch(\Exception $e){
  $output = [
    'errors' => [
      'message' => $e->getMessage(),
    ]
    ];
}

header('Content-Type: application/json');
echo json_encode($output);

?>










use Src\Controller\ProductController;
use Src\Controller\CartController;
use Src\Repository\ProductRepository;
use Src\Repository\CartRepository;
use Src\Routing\Router;

$pdo = require __DIR__ . "/config/database.php";

$productRepository = new ProductRepository($pdo);
$cartRepository = new CartRepository($pdo);

$productController = new ProductController($productRepository);
$cartController = new CartController($cartRepository);

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$router = new Router(
  $requestMethod , 
  $requestUri ,
  [ 
  "ProductController" => $productController , 
  "CartController" => $cartController
  ]
);

$router->run();
