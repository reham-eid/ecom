<?php

namespace Graphql\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PriceType extends ObjectType
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance ) {
            self::$instance = new ObjectType([
                'name' => 'Price',
                'fields' => [
                    'amount' => [
                        'type' => Type::float() ,
                        'resolve' => function ($price) {
                            return method_exists($price, 'getAmount') ? $price->getAmount() : null;
                        }
                    ],
                    'currency' => [
                        'type' => CurrencyType::getInstance(),
                        'resolve' => function ($price) {
                            return method_exists($price, 'getCurrency') ? $price->getCurrency() : null;
                        }
                    ],
                    '__typename' => [
                        'type' => Type::string(),
                        'resolve' => function ($price) {
                            return $price->getTypename();
                        }
                    ],
                ],
            ]);
        }
    
        return self::$instance;
    } 
}