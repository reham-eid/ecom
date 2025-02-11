<?php

namespace Src\Controllers;

use GuzzleHttp\Psr7\Response;
use Src\Repository\ProductRepository;

class ProductController{

    private $productRepository;

    public function __construct( ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function processRequest($method , $id = null){
        error_log("Processing request: method=$method, id=$id");

        switch($method){
            case 'GET':
                if ($id) {
                    $this->getProduct($id);
                }else{
                    $this->getAllProducts();
                }
                break;
            default: 
                $response = new Response(
                405 , 
                ['Content-Type' => 'application/json'],
                json_encode(['message' => 'Method not allowed'])
            );
            echo $response->getBody();
            break;
        }
    }

    private function getAllProducts(){
        $products = $this->productRepository->findAll();
        if ($products) {
            $response = new Response(
                200 , 
                ['Content-Type' => 'application/json'],
                json_encode($products)
            );
            echo $response->getBody();
        }else{
            $response = new Response(
                404 , 
                ['Content-Type' => 'application/json'],
                json_encode(['message' => 'No products found'])
            );
            echo $response->getBody();
        }
    }

    private function getProduct($id)
    {
        $product = $this->productRepository->find($id);
        if ($product) {
            $response = new Response(200, ['Content-Type' => 'application/json'], json_encode($product));
        } else {
            $response = new Response(404, ['Content-Type' => 'application/json'], json_encode(['message' => 'Product not found']));
        }
        echo $response->getBody();
    }
}
?>

