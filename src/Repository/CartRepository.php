<?php

namespace Src\Repository;

use PDO;

class CartRepository{
  private $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function findAll() : array {
    $stmt = $this->pdo->query("SELECT * FROM carts");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function find($id)
  {
      $stmt = $this->pdo->prepare("SELECT * FROM cart WHERE id = :id");
      $stmt->execute(['id' => $id]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function add($userId , $productId , $quantity) {
    $stmt = $this->pdo->prepare("INSERT INTO carts (userId , product_id ,quantity) VALUES (:user_id, :product_id, :quantity)");
    $stmt->execute([
      'user_id' => $userId,
      'product_id' => $productId,
      'quantity' => $quantity
    ]);
    $this->pdo->lastInsertId();
  }

  public function update($id, $quantity){
    $stmt = $this->pdo->prepare("UPDATE carts SET quantity= :quantity WHERE id= :id");
    $stmt->execute([
      'quantity' => $quantity,
      'id' => $id
    ]);
  }

  public function delete($id){
    $stmt = $this->pdo->prepare("DELETE FROM carts WHERE id= :id");
    $stmt->execute([
      'id' => $id
    ]);
  }
}
?>