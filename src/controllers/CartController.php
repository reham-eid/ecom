<?php

namespace Src\Controller;

use GuzzleHttp\Psr7\Response;
use Src\Repository\CartRepository;

class CartController
{
    private $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function processRequest($method, $id = null)
    {
        switch ($method) {
            case 'GET':
                $this->viewCart();
                break;
            case 'POST':
                $this->addToCart();
                break;
            case 'PUT':
                $this->updateCartItem($id);
                break;
            case 'DELETE':
                $this->removeCartItem($id);
                break;
            default:
                $response = new Response(
                    405,
                    ['Content-Type' => 'application/json'],
                    json_encode(['message' => 'Method not allowed']));
                echo $response->getBody();
        }
    }

    private function viewCart()
    {
        $cart = $this->cartRepository->findAll();
        $response = new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode($cart));
        echo $response->getBody();
    }

    private function addToCart()
    {
        $data = json_decode(
            file_get_contents('php://input'),
            true
        );
        $userId = $data['use_id'] ?? null;
        $productId = $data['product_id'] ?? null;
        $quantity = $data['quantity'] ?? 1;


        if ($userId && $productId) {
            $cartId = $this->cartRepository->add($userId, $productId, $quantity);
            $response = new Response(
                201, 
                ['Content-Type' => 'application/json'], 
                json_encode(['message' => 'Product added to cart', 'cart_id' => $cartId]));
        } else {
            $response = new Response(
                400, 
                ['Content-Type' => 'application/json'], 
                json_encode(['message' => 'Invalid input']));
        }
        echo $response->getBody();
    }

    private function updateCartItem($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $quantity = $data['quantity'] ?? null;

        if ($quantity) {
            $this->cartRepository->update($id, $quantity);
            $response = new Response(
                200, 
                ['Content-Type' => 'application/json'], 
                json_encode(['message' => 'Cart item updated']));
        } else {
            $response = new Response(
                400, 
                ['Content-Type' => 'application/json'], 
                json_encode(['message' => 'Invalid input']));
        }
        echo $response->getBody();
    }

    private function removeCartItem($id)
    {
        $this->cartRepository->delete($id);
        $response = new Response(
            200, 
            ['Content-Type' => 'application/json'], 
            json_encode(['message' => 'Cart item removed']));
        echo $response->getBody();
    }

}