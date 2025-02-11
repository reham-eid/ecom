<?php

namespace Graphql\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OrderType extends ObjectType
{
    // Static property to hold the single instance
    private static $instance;

    private function __construct()
    {
        $config = [
            'name' => 'Order',
            'fields' => [
                'id' => ['type' => Type::id()],
                'productId' => ['type' => Type::id()],
                'quantity' => ['type' => Type::int()],
                'totalPrice' => ['type' => Type::float()],
                'createdAt' => ['type' => Type::string()],
            ],
        ];
        parent::__construct($config);
    }

    // Public method to access the single instance
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}