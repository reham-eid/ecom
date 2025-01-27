<?php

namespace src\model;

abstract class Product {

    public function __construct(
        protected $id,
        protected $name,
        protected $inStock,
        protected $gallery,
        protected $description,
        protected $category,
        protected $attributes,
        protected $prices,
        protected $brand,
    ) {}

    // Common methods
    public function getName() {
        return $this->name;
    }

    public function getPrices() {
        return $this->prices;
    }

    // Abstract method (must be implemented by subclasses)
    abstract public function getDetails();
}
?>
// class ProductModel {
//     private $pdo;

//     public function __construct($pdo) {
//         $this->pdo = $pdo;
//     }

//     public function getAllProducts() {
//         $stmt = $this->pdo->query("SELECT * FROM products");
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }

//     public function getProductById($id) {
//         $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
//         $stmt->execute([$id]);
//         return $stmt->fetch(PDO::FETCH_ASSOC);
//     }
// }