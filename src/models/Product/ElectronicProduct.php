<?php

namespace src\models\Product;

use src\models\Category\ElectronicsCategory;
use src\models\Product\Product;

class ElectronicProduct extends Product {
  private $warranty;

  public function __construct($id, $name, $price, $warranty) {
      parent::__construct($id, $name, $price, new ElectronicsCategory(1, "Electronics"));
      $this->warranty = $warranty;
  }

  public function getDetails() {
      return "Electronic Product: {$this->name}, Price: {$this->price}, Warranty: {$this->warranty} years, Category: " . $this->getCategoryName();
  }
}

?>