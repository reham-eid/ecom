<?php

namespace Src\Models\Product;

use Src\Models\Product\Product;

class ConfigurableProduct extends Product {
    protected $attributes = [];

    public function getDetails() {
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->prices,
            'category' => $this->category,
            'brand' => $this->brand,
            'inStock' => $this->inStock,
            'description' => $this->description,
            'gallery' => $this->gallery->getImages(),
            'attributes' => $this->attributes,
        ];
    }

    // public function loadAttributes() {
    //     $stmt = $this->pdo->prepare('SELECT * FROM attributes WHERE product_id = :product_id');
    //     $stmt->execute(['product_id' => $this->id]);
    //     $this->attributes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function getAttributes() {
        return $this->attributes;
    }
}

?>
