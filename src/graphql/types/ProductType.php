<?php

namespace graphql\types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductType extends ObjectType
{
  public function __construct()
  {
    $config = [
      'name' => 'Product',
      'fields' => [
        'id' => ['type' => Type::id()],
        'name' => ['type' => Type::string()],
        'inStock' => ['type' => Type::boolean()],
        'gallery' => ['type' => Type::listOf(Type::string())],
        'description' => ['type' => Type::string()],
        'category' => ['type' => Type::string()],
        'attributes' => ['type' => Type::listOf(function(){
          return new AttributeSetType();
        })],
        'prices' => ['type' => Type::listOf(function(){
            return new PriceType();
        })],
        'brand' =>['type' => Type::string()],
      ]
    ];

    parent::__construct($config);
  }
}
?>