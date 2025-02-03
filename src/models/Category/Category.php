<?php

namespace src\models\Category;

abstract class Category {
  protected $id;
  protected $name;
  protected $__typename;

  public function __construct($id, $name,$__typename) {
      $this->id = $id;
      $this->name = $name;
      $this->__typename = $__typename;
  }

  abstract public function getProducts();
}

?>