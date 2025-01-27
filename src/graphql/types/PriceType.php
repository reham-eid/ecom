<?php

namespace graphql\types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PriceType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Price',
            'fields' => [
                'amount' => ['type' => Type::float()],
                'currency' => ['type' => function() {
                    return new CurrencyType();
                }],
            ],
        ];
        parent::__construct($config);
    }
}