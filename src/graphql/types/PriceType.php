<?php

namespace graphql\types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PriceType extends ObjectType
{
    private static $instance;

    private function __construct()
    {
        $config = [
            'name' => 'Price',
            'fields' => [
                'amount' => ['type' => Type::float()],
                'currency' => ['type' => CurrencyType::getInstance()],
            ],
        ];
        
        parent::__construct($config);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    } 
}