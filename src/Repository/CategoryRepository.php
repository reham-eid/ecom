<?php

namespace Src\Repository;

use PDO;
use Src\Factory\CategoryFactory;

class CategoryRepository {
    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Fetch all categories from the database
    public function fetchAllCategories() {
      try{
        $stmt = $this->pdo->prepare("SELECT id, name, __typename FROM categories");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
        foreach ($rows as $row) {
          if (!isset($row['id']) || $row['id'] === null) {
            // You might log an error here or throw an exception
            error_log("Category row missing id: " . print_r($row, true));
        }
            $categories[] = CategoryFactory::create($this->pdo, $row);
        }
        // echo "Categories fetched from repository";
        // echo json_encode($categories);
        return $categories;
        } catch (\PDOException $e) {
        // Log any errors that occur
        error_log("Error fetching categories: " . $e->getMessage());
        return [];
      }
    }

    // Fetch categories filtered by __typename (e.g., 'Clothes' or 'Tech')
    public function fetchCategoriesByName(string $name) {

      try{
        $stmt = $this->pdo->prepare("SELECT id, name, __typename FROM categories WHERE name = :name");
        $stmt->execute(['name' => $name]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
        foreach ($rows as $row) {
          
            $categories[] = CategoryFactory::create($this->pdo, $row);
        }
        return $categories;
      } catch (\PDOException $e) {
        // Log any errors that occur
        error_log("Error fetching categories: " . $e->getMessage());
        return [];
      }
    }




  //   public function getCategoryById($id) {
  //     $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE id = :id');
  //     $stmt->execute(['id' => $id]);
  //     return $stmt->fetch(PDO::FETCH_ASSOC);
  // }

  // public function getElectronicsAttributes($categoryId) {
  //     $stmt = $this->pdo->prepare('SELECT * FROM electronics_attributes WHERE category_id = :category_id');
  //     $stmt->execute(['category_id' => $categoryId]);
  //     return $stmt->fetch(PDO::FETCH_ASSOC);
  // }

  // public function getClothingAttributes($categoryId) {
  //     $stmt = $this->pdo->prepare('SELECT * FROM clothing_attributes WHERE category_id = :category_id');
  //     $stmt->execute(['category_id' => $categoryId]);
  //     return $stmt->fetch(PDO::FETCH_ASSOC);
  // }
}
?>
