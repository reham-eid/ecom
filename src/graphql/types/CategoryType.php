<?php

namespace graphql\types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CategoryType extends ObjectType
{
    // Static property to hold the single instance
    private static $instance;

    private function __construct()
    {
        $config = [
            'name' => 'Category',
            'fields' => [
                'name' => ['type' => Type::string()],
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