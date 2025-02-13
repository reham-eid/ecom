<?php

namespace Graphql\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeType extends ObjectType
{
    // Static property to hold the single instance
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance ) {
            self::$instance = new ObjectType([
            'name' => 'Attribute',
            'fields' => [
                'id' => [
                    'type' => Type::id(),
                    'resolve'=> function($items)  { 
                        return $items->getId();
                    },
                ],
                'displayValue' => [
                    'type' => Type::string(),
                    'resolve'=> function($items)  {
                        return $items->getDisplayValue();
                    },
                ],
                'value' => [
                    'type' => Type::string(),
                    'resolve'=> function($items)  {
                        return $items->getValue();
                    },
                ],
                '__typename' => [
                    'type' => Type::string(),
                    'resolve'=> function($items)  {
                        return $items->getTypename();
                    },
                ],
            ],
        ]);

    }

    return self::$instance;

    }
}
