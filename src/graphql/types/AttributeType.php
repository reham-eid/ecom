<?php

namespace graphql\types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeType extends ObjectType
{
    // Static property to hold the single instance
    private static $instance;

    // Private constructor to prevent direct instantiation
    private function __construct()
    {
        $config = [
            'name' => 'Attribute',
            'fields' => [
                'id' => ['type' => Type::id()],
                'name' => ['type' => Type::string()],
                'value' => ['type' => Type::string()],
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
