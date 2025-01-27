<?php
namespace src\repository;

use PDO;

class ProductRepository{
  private $pdo;

  public function __construct(PDO $pdo){
    $this->pdo = $pdo;
  }

  public function findAll(): array{
    $stmt = $this->pdo->query("SELECT * FROM `products` ");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Fetched products: " . json_encode($products));
    return $products;
  }

  public function find($id): object {
    $stmt = $this->pdo->prepare("SELECT * FROM `products` WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    error_log("Fetched products: " . json_encode($product));
    return $product;
}
}

?>