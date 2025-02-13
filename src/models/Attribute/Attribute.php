<?php

namespace Src\Models\Attribute; 


class Attribute {
  protected $pdo;
  protected $id;
  protected $attributes_id;
  protected $displayValue;
  protected $value;
  protected $__typename;

  public function __construct( $pdo , $id, $attributes_id, $displayValue, $value, $__typename) {
    $this->pdo = $pdo;
    $this->id = $id;
    $this->attributes_id = $attributes_id;
    $this->displayValue = $displayValue;
    $this->value = $value;
    $this->__typename = $__typename;
  }

  // Getter
  public function getId() { return $this->id; }
  public function getAttributeId() { return $this->attributes_id; }
  public function getDisplayValue() { return $this->displayValue; }
  public function getValue() { return $this->value; }
  public function getTypename() { return $this->__typename; }


  
}
?>