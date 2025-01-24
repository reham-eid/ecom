<?php
namespace Src\Repository;

use PDO;

class ProductRepository{
  private $pdo;

  public function __construct(PDO $pdo){
    $this->pdo = $pdo;
  }

  public function findAll(): array{
    $stmt = $this->pdo->query("SELECT * FROM products");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function find($id): object {
    $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}

?>