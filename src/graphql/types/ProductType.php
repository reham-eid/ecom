<?php

namespace Graphql\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Graphql\Types\CategoryType;

class ProductType extends ObjectType
{
  // Static property to hold the single instance
  private static $instance;

  public static function getInstance() {
    if (!self::$instance) {
        self::$instance = new ObjectType([
          'name' => 'Product',
          'fields' => [
            'id'  => [
              'type'    => Type::nonNull(Type::id()),
              'resolve' => function($product ) {
                  return $product->getId();
              }
            ],
            'name' => [
              'type'    => Type::string(),
              'resolve' => function($product ) {
                  return $product->getName();
              }
            ],
            'inStock' => [
              'type'    => Type::boolean(),
              'resolve' => function($product ) {
                  return $product->getInStock();
              }
            ],
            'gallery' => [
              'type'    => Type::listOf(Type::string()),
              'resolve' => function($product ) {
                  return $product->getGallery();
              }
            ],        
            'description' => [
              'type'    => Type::string(),
              'resolve' => function($product ) {
                  return $product->getDescription();
              }
            ],
            'category' => [
              'type'    => CategoryType::getInstance(),
              'resolve' => function($product) {
                return $product->getCategory();
              }
            ],
            'attributes' => ['type' => Type::listOf(AttributeSetType::getInstance()),
            'resolve' => function ($root, $args) {
              error_log("root from getAttributes productType: " . print_r($root, true));
    
              // return method_exists($root, 'getAttributes') ? $root->getAttributes() : [];
              if (method_exists($root, 'getAttributes')) {
                error_log(print_r($root->getAttributes(), true));  
                return $root->getAttributes();
              }
              },

            ],
            'prices' => [
              'type' => Type::listOf(PriceType::getInstance() ),
              'resolve' => function ($root, $args) {
                // error_log(print_r($root['prices'], true));
                // error_log(" root from prices productType: " . print_r($root, true));
                return method_exists($root, 'getPrices') ? $root->getPrices() : []; 
            },
          ],
            'brand' => [
              'type'    => Type::string(),
              'resolve' => function($product ) {
                  return $product->getBrand();
              }
            ],
            '__typename' => [
              'type'    => Type::string(),
              'resolve' => function($product ) {
                  return $product->getTypename();
              }
            ],
          ]
        ]);
    }
    return self::$instance;
  }
}
?>

