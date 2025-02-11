<?php

namespace Graphql\Schemas;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use Graphql\Resolvers\OrderResolver;

class OrderSchema
{
    /**
     * Defines the OrderResponse Type
     * @return ObjectType
     */
    public static function getOrderResponseType(): ObjectType
    {
        return new ObjectType([
            'name' => 'OrderResponse',
            'fields' => [
                'success' => Type::boolean(),
                'message' => Type::string(),
                'order_id' => Type::id()
            ]
        ]);
    }

    /**
     * Defines the OrderItemInput Type
     * @return InputObjectType
     */
    public static function getOrderItemInputType(): InputObjectType
    {
        return new InputObjectType([
            'name' => 'OrderItemInput',
            'fields' => [
                'product_id' => Type::nonNull(Type::id()),
                'quantity' => Type::nonNull(Type::int())
            ]
        ]);
    }

    /**
     * Defines the OrderInput Type
     * @return InputObjectType
     */
    public static function getOrderInputType(): InputObjectType
    {
        return new InputObjectType([
            'name' => 'OrderInput',
            'fields' => [
                'user_id' => Type::nonNull(Type::id()),
                'total_price' => Type::nonNull(Type::float()),
                'items' => Type::nonNull(Type::listOf(self::getOrderItemInputType()))
            ]
        ]);
    }

    /**
     * Defines the GraphQL Order Schema
     * @return array
     */
    public static function getSchema(): array
    {
        return [
            'placeOrder' => [
                'type' => self::getOrderResponseType(),
                'args' => [
                    'input' => Type::nonNull(self::getOrderInputType())
                ],
                'resolve' => function ($root, $args,) {
                        return OrderResolver::placeOrder($args);
                    }
            ]
        ];
    }
}
