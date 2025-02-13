<?php

namespace Src\Models\Category;


abstract class Category {
    protected $pdo;
    protected $id;
    protected $name;
    protected $products;
    protected $__typename;
    // protected $attributes = [];
    protected $repository;

    public function __construct($pdo, $id, $name, $typename) {
        $this->pdo = $pdo;
        $this->id = $id;
        $this->name = $name;
        $this->__typename = $typename;
        
        $this->products = [];
    }

      // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getTypename() { return $this->__typename; }
    public function getProducts() { return $this->products; }
    // public function getAttributes() {
    //     return $this->attributes;
    // }

      // Setters (if needed)
    public function setName($name): void { $this->name = $name; }
    public function setTypename($typename): void { $this->__typename = $typename; }
    public function setProducts($products): void { $this->products = $products; }

      // abstract public function loadAttributes(): array;
    
    public function getDetails(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->__typename
        ];
    }


  // public function loadProducts() { // abstract method 
  //   $stmt = $this->pdo->prepare('SELECT * FROM products WHERE category = :category');
  //   $stmt->execute(['category' => $this->id]);
  //   $this->products = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // }
}

?>



