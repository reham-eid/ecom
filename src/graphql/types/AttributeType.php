<?php

namespace GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeType extends ObjectType
{
    public function __construct()
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
}