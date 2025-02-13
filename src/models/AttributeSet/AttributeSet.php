<?php

namespace Src\Models; 


class AttributeSet {
  protected $pdo;
  protected $id;
  protected $attribute_id;
  protected $displayValue;
  protected $value;
  protected $__typename;

  public function __construct( $pdo , $id, $attribute_id, $displayValue, $value, $__typename) {
    $this->pdo = $pdo;
    $this->id = $id;
    $this->attribute_id = $attribute_id;
    $this->displayValue = $displayValue;
    $this->value = $value;
    $this->__typename = $__typename;
  }

  // Getter
  public function getId() { return $this->id; }
  public function getAttributeId() { return $this->attribute_id; }
  public function getDisplayValue() { return $this->displayValue; }
  public function getValue() { return $this->value; }
  public function getTypename() { return $this->__typename; }


}
?>