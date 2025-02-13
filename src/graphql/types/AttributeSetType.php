<?php

namespace Graphql\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeSetType extends ObjectType
{
  private static $instance;
  public static function getInstance()
  {
      if (!self::$instance ) {
          self::$instance = new ObjectType([
      'name' => 'AttributeSet',
      'fields' => [
          'id' => [
            'type' => Type::id(),
            'resolve' => function ($attributes) {
              return method_exists($attributes, 'getId') ? $attributes->getId() : null;
          }
          ],
          'name' => [
            'type' => Type::string(),
            'resolve'=> function ($attributes) {
              return method_exists($attributes,'getName') ? $attributes->getName() : null;
            }
          ],
          'type' => [
            'type' => Type::string(),
            'resolve'=> function ($attributes) { 
              return method_exists($attributes,'getType') ? $attributes->getType() : null;
            }
          ],
          'items' => [
            'type' => Type::listOf(AttributeType::getInstance()),
            'resolve' => function ($root, $args) {
                error_log(print_r($root['items'], true));
                error_log(" root from items productType: " . print_r($root, true));
                return method_exists($root, 'getItems') ? $root->getItems() : []; 
            }
          ],
          '__typename' => [
            'type' => Type::string(),
            'resolve'=> function ($attributes) { 
              return method_exists($attributes,'getTypename') ? $attributes->getTypename() : null;
            }
          ],
      ],
    ]);
  }

    return self::$instance;
  } 
}

?>