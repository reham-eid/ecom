<?php

use src\models\Attribute; 

use PDO ; 

class AttributeSet extends Attribute {
  public function loadItems() {
      $stmt = $this->pdo->prepare('SELECT * FROM items WHERE attribute_id = :attribute_id');
      $stmt->execute(['attribute_id' => $this->id]);
      $this->items = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getItems() {
      return $this->items;
  }
}
?>