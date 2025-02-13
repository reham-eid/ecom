<?php

namespace Src\Models\Attribute; 


abstract class Attribute {
  protected $pdo;
  protected $id;
  protected $name;
  protected $items ;
  protected $type;
  protected $__typename;

  public function __construct($pdo, $id, $name, array $items, $type, $__typename) {
      $this->pdo = $pdo;
      $this->id = $id;
      $this->name = $name;
      $this->items = $items;
      $this->type = $type;
      $this->__typename = $__typename;
  }

  public function getItems() {
    return array_map(fn($item) => [
        "id" => $item->getId(),
        "displayValue" => $item->getDisplayValue(),
        "value" => $item->getValue(),
        "__typename" => $item->getTypename(),
    ], $this->items);
  }

}
  // abstract public function getItems();
  
  // abstract public function getValue();

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

