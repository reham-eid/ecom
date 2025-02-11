<?php

namespace src\models;


class OrderItem {
    protected $product;
    protected $quantity;

    public function __construct(Product $product, $quantity) {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getProduct() {
        return $this->product;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getSubtotal() {
        $productPrice = $this->product->getPrices()[0]->amount; // Assuming a single price per product
        return $this->quantity * $productPrice;
    }

    public function getDetails() {
        return [
            'product' => $this->product->getDetails(),
            'quantity' => $this->quantity,
            'subtotal' => $this->getSubtotal()
        ];
    }
}
?>
