<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use Graphql\Types\ProductType;
use Graphql\Types\CategoryType;
use Graphql\Types\AttributeType;
// use graphql\types\OrderType;
use Graphql\Resolvers\ProductResolver;
use Graphql\Resolvers\CategoryResolver;
use Graphql\Resolvers\AttributeResolver;
// use graphql\resolvers\OrderResolver;

use Graphql\Schemas\OrderSchema;
// Query Type
$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'products' => [
            'type' => Type::listOf(ProductType::getInstance()), // Use Singleton
            'args' => [
                'id' => ['type' => Type::id()],
            ],
            'resolve' => function ($root, $args) {
                if (isset($args['id'])) {
                    return ProductResolver::fetchProductById($args['id']);
                }
                return ProductResolver::fetchProducts();
            },
        ],
        // 'categories' => [
        //     'type' => Type::listOf(CategoryType::getInstance()), // Use Singleton
        //     'resolve' => function () {
        //         return CategoryResolver::fetchCategories();
        //     },
        // ],
        // 'category' => [
        //     'type' => CategoryType::getInstance(), // Use Singleton
        //     'args' => [
        //         'id' => ['type' => Type::id()],
        //     ],
        //     'resolve' => function ($root, $args) {
        //         return CategoryResolver::fetchCategoryById($args['id']);
        //     },
        // ],

        'AllCategories' => [
            'type'    => Type::listOf(CategoryType::getInstance()),
            'resolve' => function() {
                return CategoryResolver::GetAllCategories();
            }
        ],
        'Clothes' => [
            'type'    => Type::listOf(CategoryType::getInstance()),
            'resolve' => function() {
                return CategoryResolver::GetClothes();
                
            }
        ],
        'Tech' => [
            'type'    => Type::listOf(CategoryType::getInstance()),
            'resolve' => function() {
                return CategoryResolver::GetTech();
            }
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
    'fields' => array_merge(OrderSchema::getSchema())
]);

// Create the Schema
return new Schema([
    'query' => $queryType,
    'mutation' => $mutationType,
]);

?>