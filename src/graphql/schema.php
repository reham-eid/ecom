<?php
// graphql/schema.php
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

$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'products' => [
            'type' => Type::listOf(new ProductType()),
            'resolve' => function () {
                return ProductResolver::fetchProducts();
            }
        ],
        'product' => [
            'type' => new ProductType(),
            'args' => [
                'id' => ['type' => Type::id()],
            ],
            'resolve' => function ($root, $args) {
                return ProductResolver::fetchProductById($args['id']);
            },
        ],
        'categories' => [
            'type' => Type::listOf(new CategoryType()),
            'resolve' => function () {
                return CategoryResolver::fetchCategories();
            },
        ],
        'category' => [
            'type' => new CategoryType(),
            'args' => [
                'id' => ['type' => Type::id()],
            ],
            'resolve' => function ($root, $args) {
                return CategoryResolver::fetchCategoryById($args['id']);
            },
        ],
        'attributes' => [
            'type' => Type::listOf(new AttributeType()),
            'resolve' => function () {
                return AttributeResolver::fetchAttributes();
            },
        ],
        'attribute' => [
            'type' => new AttributeType(),
            'args' => [
                'id' => ['type' => Type::id()],
            ],
            'resolve' => function ($root, $args) {
                return AttributeResolver::fetchAttributeById($args['id']);
            },
        ],
    ]
]);

// Define the Mutation type
$mutationType = new ObjectType([
    'name' => 'Mutation',
    'fields' => [
        'createOrder' => [
            'type' => new OrderType(),
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

// Create the schema
return new Schema([
    'query' => $queryType,
    'mutation' => $mutationType,
]);
?>