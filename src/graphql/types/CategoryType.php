<?php

namespace Graphql\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CategoryType {
    private static $instance;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new ObjectType([
                'name'   => 'Category',  
                'fields' => [
                    'id' => [
                        'type'    => Type::nonNull(Type::id()),
                        'resolve' => function($category, $args, $context, $info) {
                            return $category->getId();
                        }
                    ],
                    'name' => [
                        'type'    => Type::string(),
                        'resolve' => function($category) {
                            return $category->getName();
                        }
                    ],
                    '__typename' => [
                        'type'    => Type::string(),
                        'resolve' => function($category) {
                            return $category->getTypename();
                        }
                    ],
                    // Add any other fields as needed.
                ]
            ]);
        }
        return self::$instance;
    }
}
