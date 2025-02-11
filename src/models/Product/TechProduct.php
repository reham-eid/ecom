<?php

use src\models\Product;

class TechProduct extends Product {
    private $attributes = [];

    public function getDetails() {
        return "Tech Product: $this->name, Category: $this->category";
    }

    public function loadAttributes() {
        $stmt = $this->pdo->prepare('SELECT * FROM attributes WHERE product_id = :product_id');
        $stmt->execute(['product_id' => $this->id]);
        $this->attributes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAttributes() {
        return $this->attributes;
    }
}

?>
