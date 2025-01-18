<?php

class CartController {
    private $cart;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $this->cart = &$_SESSION['cart'];
    }

    public function addToCart($productId) {
        if (!isset($this->cart[$productId])) {
            $this->cart[$productId] = 0;
        }
        $this->cart[$productId]++;
        echo json_encode(['message' => 'Product added to cart']);
    }

    public function viewCart() {
        echo json_encode($this->cart);
    }
}