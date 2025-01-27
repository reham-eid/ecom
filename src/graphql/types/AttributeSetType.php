<?php

namespace graphql\types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeSetType extends ObjectType
{
  public function __construct()
  {
    $config = [
      'name' => 'AttributeSet',
      'fields' => [
          'id' => ['type' => Type::id()],
          'name' => ['type' => Type::string()],
          'type' => ['type' => Type::string()],
          'items' => ['type' => Type::listOf(function() {
              return new AttributeType();
          })],
      ],
    ];
    parent::__construct($config);
  }

}

?>