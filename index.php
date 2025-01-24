<?php

require_once __DIR__ . '/vendor/autoload.php';

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
?>