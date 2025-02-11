<?php

namespace src\models; 

use PDO ; 

abstract class Attribute {
  protected $pdo;
  protected $id;
  protected $name;
  protected $items = [];
  protected $type;
  protected $__typename;

  public function __construct($pdo, $id, $name, $type, $__typename) {
      $this->pdo = $pdo;
      $this->id = $id;
      $this->name = $name;
      $this->type = $type;
      $this->__typename = $__typename;
  }

  abstract public function loadItems();
  
  // abstract public function getValue();
}

// class SizeAttribute extends Attribute {
//   public function getValue() {
//       return "Size: $this->name";
//   }
// }

// class ColorAttribute extends Attribute {
//   public function getValue() {
//       return "Color: $this->name";
//   }
// }

?>