<?php

namespace Src\Models\Product; 

use Src\Models\Category\Category; 
use Src\Models\Gallery\Gallery;


abstract class Product {
    protected $pdo;
    protected $id;
    protected $name;
    protected $inStock;
    protected $description;
    protected $category;
    protected $brand;
    protected $attributes = [];
    protected $gallery;
    protected array $prices; 
    protected $__typename;

    public function __construct(
        $pdo,
        $id,
        $name, 
        $inStock, 
        $description, 
        Category $category, 
        array $prices,
        Gallery $gallery, 
        $brand, 
        $__typename,
        array $attributes,
        ) {
        $this->pdo = $pdo;
        $this->id = $id;
        $this->name = $name;
        $this->inStock = $inStock;
        $this->description = $description;
        $this->category = $category; 
        $this->prices = $prices; 
        $this->gallery = $gallery; 
        $this->brand = $brand;
        $this->attributes = $attributes ?? [];
        $this->__typename = $__typename;
    }

    
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getInStock() { return $this->inStock; }
    public function getDescription() { return $this->description; }
    public function getGallery() { return $this->gallery->getImages(); }
    public function getCategory() { return $this->category; }
    public function getPrices() { return $this->prices; }
    public function getBrand() { return $this->brand; }
    public function getTypename() { return $this->__typename; }
    public function getAttributes() {
        return is_array($this->attributes) ? $this->attributes : [];
    }
    abstract public function getDetails();

    // abstract public function loadAttributes();
    // public function loadAttributes() {
    //     $stmt = $this->pdo->prepare('SELECT * FROM attributes WHERE product_id = :product_id');
    //     $stmt->execute(['product_id' => $this->id]);
    //     $this->attributes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }


    // public function getAttributes() {
    //     return $this->attributes;
    // }


}
?>
