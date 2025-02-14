<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use Graphql\Types\ProductType;
use Graphql\Types\CategoryType;
use Graphql\Types\AttributeSetType;
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
                    return ProductResolver::GetAllProducts();
            }
        ],

        'product' => [
            'type' => ProductType::getInstance(),  
            'args' => [
                'id' => ['type' => Type::id()],
            ],
            'resolve' => function ($root, $args) {
                return ProductResolver::GetProduct($args['id']);  
            },
        ],

        'productsByCategory' => [
            'type' => Type::listOf(ProductType::getInstance()),
            'args' => [
                'categoryId' => ['type' => Type::id()],
            ],
            'resolve' => function($root, $args ) {
                return ProductResolver::GetProductsByCategory($args['categoryId']);  
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
        'attributeSet' => [
            'type' => Type::listOf(AttributeSetType::getInstance()), // Use Singleton
            'args' => [
                'id' => ['type' => Type::id()],
            ],
            'resolve' => function ($root, $args) {
                return AttributeResolver::fetchAttributesByProductId($args['id']);
            },
        ],
        'attribute' => [
            'type' => AttributeSetType::getInstance(), // Use Singleton
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