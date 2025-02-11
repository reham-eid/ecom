<?php

namespace Graphql\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeSetType extends ObjectType
{
  private static $instance;

  private function __construct()
  {
    $config = [
      'name' => 'AttributeSet',
      'fields' => [
          'id' => ['type' => Type::id()],
          'name' => ['type' => Type::string()],
          'type' => ['type' => Type::string()],
          'items' => ['type' => Type::listOf(function() {
              return AttributeType::getInstance();
          })],
          '__typename' => ['type' => Type::string()],
      ],
    ];
    parent::__construct($config);
  }

  public static function getInstance()
  {
      if (self::$instance === null) {
          self::$instance = new self();
      }
      return self::$instance;
  }

}

?>