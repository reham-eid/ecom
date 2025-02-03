<?php

namespace src\models\Product;

use src\models\ProductGallery\ProductGallery;

abstract class Product {
    protected $id;
    protected $name;
    protected $inStock;
    protected $description;
    protected $brand;
    protected $attributes;
    protected $gallery;

    public function __construct( $id, $name, $inStock, $description, $brand, $attributes , $galleryImages) {
        $this->$id = $id;
        $this->$name = $name;
        $this->$inStock = $inStock;
        $this->$description = $description;
        $this->$brand = $brand;
        $this->$attributes = $attributes ;
        $this->gallery = array_map(fn($img) => new ProductGallery($id, $img), $galleryImages);

    }

    // Common methods
    public function getGallery() {
        return array_map(fn($galleryItem) => $galleryItem->getImageUrl(), $this->gallery);
    }

    // Abstract method (must be implemented by subclasses)
    abstract public function getDetails();
}
?>

