<?php

namespace graphql\types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CurrencyType extends ObjectType
{
    private static $instance;
    
    private function __construct()
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

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}