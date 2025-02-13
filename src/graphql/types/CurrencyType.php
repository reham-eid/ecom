<?php

namespace Graphql\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CurrencyType extends ObjectType
{
    private static $instance;
    
    public static function getInstance() {

    if (!self::$instance) {
        self::$instance = new ObjectType([
            'name' => 'Currency',
            'fields' => [
                'label' => [
                    'type'    => Type::string(),
                    'resolve' => function($currency) {
                        return $currency->getLabel();
                    }
                ],
                'symbol' => [
                    'type'    => Type::string(),
                    'resolve' => function($currency) {
                        return $currency->getSymbol();
                    }
                ],
                '__typename' => [
                    'type'    => Type::string(),
                    'resolve' => function($currency) {
                        return $currency->getTypename();
                    }
                ],
            ],
        ]);
    }
    return self::$instance;

    }

}
