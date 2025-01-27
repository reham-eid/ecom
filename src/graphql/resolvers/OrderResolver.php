<?php

namespace graphql\resolvers;

class OrderResolver
{
    public static function createOrder($productId, $quantity)
    {
        // Mock data for creating an order
        return [
            'id' => uniqid(),
            'productId' => $productId,
            'quantity' => $quantity,
            'totalPrice' => 19.99 * $quantity,
            'createdAt' => date('Y-m-d H:i:s'),
        ];
    }
}