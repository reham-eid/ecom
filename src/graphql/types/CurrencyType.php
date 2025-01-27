<?php

namespace graphql\types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CurrencyType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Currency',
            'fields' => [
                'label' => ['type' => Type::string()],
                'symbol' => ['type' => Type::string()],
            ],
        ];
        parent::__construct($config);
    }
}