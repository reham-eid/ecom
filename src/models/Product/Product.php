<?php

namespace src\models; 

use src\models\Category; 

use PDO ; 

abstract class Product {
    protected $pdo;
    protected $id;
    protected $name;
    protected $inStock;
    protected $description;
    protected $category;
    protected $brand;
    protected $attributes = [];
    protected $gallery = [];
    protected $prices = [];
    protected $__typename;

    public function __construct($pdo, $id, $name, $inStock, $description, Category $category, $brand, $__typename) {
        $this->pdo = $pdo;
        $this->id = $id;
        $this->name = $name;
        $this->inStock = $inStock;
        $this->description = $description;
        $this->category = $category; // get name
        $this->brand = $brand;
        $this->__typename = $__typename;
    }

    abstract public function getDetails();

    abstract public function loadAttributes();
    // public function loadAttributes() {
    //     $stmt = $this->pdo->prepare('SELECT * FROM attributes WHERE product_id = :product_id');
    //     $stmt->execute(['product_id' => $this->id]);
    //     $this->attributes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function loadGallery() {
        $stmt = $this->pdo->prepare('SELECT * FROM gallery WHERE product_id = :product_id');
        $stmt->execute(['product_id' => $this->id]);
        $this->gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function loadPrices() { // abstract
        // each product has a diff array 
        $stmt = $this->pdo->prepare('SELECT * FROM prices WHERE product_id = :product_id');
        $stmt->execute(['product_id' => $this->id]);
        $this->prices = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function getAttributes() {
    //     return $this->attributes;
    // }

    public function getGallery() {
        return $this->gallery;
    }

    public function getPrices() {
        return $this->prices;
    }
}
?>
