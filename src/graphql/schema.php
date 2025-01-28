<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use graphql\types\ProductType;
use graphql\types\CategoryType;
use graphql\types\AttributeType;
use graphql\types\OrderType;
use graphql\resolvers\ProductResolver;
use graphql\resolvers\CategoryResolver;
use graphql\resolvers\AttributeResolver;
use graphql\resolvers\OrderResolver;

// Query Type
$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'products' => [
            'type' => Type::listOf(ProductType::getInstance()), // Use Singleton
            'resolve' => function () {
                return ProductResolver::fetchProducts();
            },
        ],
        'product' => [
            'type' => ProductType::getInstance(), // Use Singleton
            'args' => [
                'id' => ['type' => Type::id()],
            ],
            'resolve' => function ($root, $args) {
                return ProductResolver::fetchProductById($args['id']);
            },
        ],
        'categories' => [
            'type' => Type::listOf(CategoryType::getInstance()), // Use Singleton
            'resolve' => function () {
                return CategoryResolver::fetchCategories();
            },
        ],
        'category' => [
            'type' => CategoryType::getInstance(), // Use Singleton
            'args' => [
                'id' => ['type' => Type::id()],
            ],
            'resolve' => function ($root, $args) {
                return CategoryResolver::fetchCategoryById($args['id']);
            },
        ],
        'attributes' => [
            'type' => Type::listOf(AttributeType::getInstance()), // Use Singleton
            'resolve' => function () {
                return AttributeResolver::fetchAttributes();
            },
        ],
        'attribute' => [
            'type' => AttributeType::getInstance(), // Use Singleton
            'args' => [
                'id' => ['type' => Type::id()],
            ],
            'resolve' => function ($root, $args) {
                return AttributeResolver::fetchAttributeById($args['id']);
            },
        ],
    ],
]);

// Mutation Type
$mutationType = new ObjectType([
    'name' => 'Mutation',
    'fields' => [
        'createOrder' => [
            'type' => OrderType::getInstance(), // Use Singleton
            'args' => [
                'productId' => ['type' => Type::id()],
                'quantity' => ['type' => Type::int()],
            ],
            'resolve' => function ($root, $args) {
                return OrderResolver::createOrder($args['productId'], $args['quantity']);
            },
        ],
    ],
]);

// Create the Schema
return new Schema([
    'query' => $queryType,
    'mutation' => $mutationType,
]);

?>