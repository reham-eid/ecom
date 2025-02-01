<?php

namespace graphql\types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductType extends ObjectType
{
  // Static property to hold the single instance
  private static $instance;

  private function __construct()
  {
    $config = [
      'name' => 'Product',
      'fields' => [
        'id' => ['type' => Type::id()],
        'name' => ['type' => Type::string()],
        'inStock' => ['type' => Type::boolean()],
        'gallery' => [
            'type' => Type::listOf(Type::string())
            // 'resolve' => function ($root, $args) {
            //     return isset($root['gallery']) ? json_decode($root['gallery'], true) : [];
            // },
        ],        
        'description' => ['type' => Type::string()],
        'category' => [
          'type' => Type::string(),
          // 'resolve' => function ($parent) {
            //     // Assuming you have a CategoryModel with a findById method
            //     return CategoryModel::findById($parent['category_id']);
            // }
        ],
        'attributes' => ['type' => Type::listOf(function(){
          return AttributeSetType::getInstance();
        })],
        'prices' => [
          'type' => Type::listOf(PriceType::getInstance() ),
          'resolve' => function ($root, $args) {
            // error_log(print_r($root['prices'], true));
            return $root['prices'] ?? [];
        },
      ],
        'brand' =>['type' => Type::string()],
        '__typename' =>['type' => Type::string()],
      ]
    ];

    parent::__construct($config);
  }

  // Public method to access the single instance
  public static function getInstance()
  {
      if (self::$instance === null) {
          self::$instance = new self();
      }
      return self::$instance;
  }
}
?>