<?php
namespace src\repository;

use PDO;


class ProductRepository{
  private $pdo;

  public function __construct(PDO $pdo){
    $this->pdo = $pdo;
  }

  public function findAll(): array {
    try {
        // Define the SQL query
        $sql = "
            SELECT
                p.id AS product_id,
                p.name,
                p.inStock,
                p.description,
                p.category,
                p.brand,
                p.typename AS product_typename,
                pg.image_url,
                pa.id AS attribute_id,
                pa.attribute_name,
                pa.attribute_type,
                pa.typename AS attribute_typename,
                ai.display_value,
                ai.value AS attribute_value,
                pp.amount,
                pp.currency_label,
                pp.currency_symbol,
                pp.typename AS price_typename
            FROM
                products p
            LEFT JOIN
                product_gallery pg ON p.id = pg.product_id
            LEFT JOIN
                product_attributes pa ON p.id = pa.product_id
            LEFT JOIN
                attribute_items ai ON pa.id = ai.attribute_id
            LEFT JOIN
                product_prices pp ON p.id = pp.product_id
        ";

        // Execute the query
        $stmt = $this->pdo->query($sql);

        // Fetch all results as an associative array
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Process the rows to group data into nested arrays
$products = [];
foreach ($rows as $row) {
    $productId = $row['product_id'];

    // Initialize the product if it doesn't exist
    if (!isset($products[$productId])) {
        $products[$productId] = [
            'product_id' => $row['product_id'],
            'name' => $row['name'],
            'inStock' => $row['inStock'],
            'description' => $row['description'],
            'category' => $row['category'],
            'brand' => $row['brand'],
            'product_typename' => $row['product_typename'],
            'gallery' => [],
            'attributes' => [],
            'prices' => []
        ];
    }

    // Add gallery image if it exists and is not already added
    if ($row['image_url'] && !in_array($row['image_url'], array_column($products[$productId]['gallery'], 'image_url'))) {
        $products[$productId]['gallery'][] = [
            'image_url' => $row['image_url']
        ];
    }

    // Add attribute if it exists and is not already added
    if ($row['attribute_id'] && !in_array($row['attribute_id'], array_column($products[$productId]['attributes'], 'attribute_id'))) {
        $products[$productId]['attributes'][] = [
            'attribute_id' => $row['attribute_id'],
            'attribute_name' => $row['attribute_name'],
            'attribute_type' => $row['attribute_type'],
            'attribute_typename' => $row['attribute_typename'],
            'display_value' => $row['display_value'],
            'attribute_value' => $row['attribute_value']
        ];
    }

    // Add price if it exists and is not already added
    if ($row['amount'] !== null && !in_array($row['amount'], array_column($products[$productId]['prices'], 'amount'))) {
        $products[$productId]['prices'][] = [
            'amount' => $row['amount'],
            'currency_label' => $row['currency_label'],
            'currency_symbol' => $row['currency_symbol'],
            'price_typename' => $row['price_typename']
        ];
    }
}

      // Convert associative array to indexed array
      $products = array_values($products);
        // Log the fetched products for debugging
        error_log("Fetched products: " . json_encode($products));

      // Output the final result
      // print_r($products);
        // Return the fetched products
        return $products;
    } catch (\PDOException $e) {
        // Log any errors that occur
        error_log("Error fetching products: " . $e->getMessage());
        return [];
    }
}

  public function find($id): object {
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM `products` WHERE id = :id");
      $stmt->execute(['id' => $id]);
      $product = $stmt->fetch(PDO::FETCH_ASSOC);
      error_log("Fetched products: " . json_encode($product));
      return $product;
    } catch (\PDOException $e) {
        // Log any errors that occur
        error_log("Error fetching products: " . $e->getMessage());
    }
}
}

?>