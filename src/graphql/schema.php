<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Types\ProductType;
use GraphQL\Types\CategoryType;
use GraphQL\Types\AttributeType;
use GraphQL\Types\OrderType;
use GraphQL\Resolvers\ProductResolver;
use GraphQL\Resolvers\CategoryResolver;
use GraphQL\Resolvers\AttributeResolver;
use GraphQL\Resolvers\OrderResolver;

$queryType = new ObjectType([
  'name' => 'Query',
  'fields' => [
    'products' =>[
      'type' => Type::listOf(new ProductType()),
      'resolve' => function(){
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
$schema = new Schema([
  'query' => $queryType,
  'mutation' => $mutationType,
]);

return $schema;
?>

