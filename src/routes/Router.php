<?php

namespace src\routes;

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
        header("Access-Control-Allow-Headers: Content-Type");
        header('Content-Type: application/json; charset=UTF-8');

        // Prepare path
        $uriParts = explode('/', $this->uri);
        array_shift($uriParts); // Remove the first empty part
        $path = $uriParts[0] ?? null; // Get the path (e.g., "products")
        $id = $uriParts[1] ?? null; // Get the ID (e.g., "123")

    // Debugging: Log the path and ID
    error_log("Path: " . $path);
    error_log("ID: " . $id);
        // Route the request
        switch ($path) {
            case '': // Root URL
                $response = new Response(
                    200,
                    ['Content-Type' => 'application/json'],
                    json_encode(['message' => 'Welcome to the E-Commerce API!'])
                );
                echo $response->getBody();
                break;
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