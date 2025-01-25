<?php

namespace GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OrderType extends ObjectType
{
    public function __construct()
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
}