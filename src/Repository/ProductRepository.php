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
            SELECT distinct 
                p.id,
                p.name AS product_name,
                p.inStock,
                p.description,
                p.category,
                p.brand,
                p.__typename AS product__typename,
                pg.image_url,
                pa.id AS attribute_id,
                pa.name,
                pa.type,
                pa.__typename AS attribute__typename,
                ai.displayValue AS item_displayValue,
                ai.value AS item_value,
                ai.__typename AS item__typename,
                pp.amount,
                pp.currency,
                pp.__typename AS price__typename,
                pc.label AS currency_label,
                pc.symbol AS currency_symbol,
                pc.__typename AS currency__typename
            FROM
                products p
            LEFT JOIN
                gallery pg ON p.id = pg.product_id
            LEFT JOIN
                attributes pa ON p.id = pa.product_id
            LEFT JOIN
                items ai ON pa.id = ai.attribute_id
            LEFT JOIN
                prices pp ON p.id = pp.product_id
            LEFT JOIN
                currency pc ON pp.currency = pc.label;";

        // Execute the query
        $stmt = $this->pdo->query($sql);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo()); // Show SQL error
        }
        // Fetch all results as an associative array
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Process the rows to group data into nested arrays
        $products = [];
        foreach ($rows as $row) {
            $productId = $row['id'];

            // Initialize the product if it doesn't exist
            if (!isset($products[$productId])) {
                $products[$productId] = [
                    'id' => $row['id'],
                    'name' => $row['product_name'],
                    'inStock' => $row['inStock'],
                    'description' => $row['description'],
                    'category' => $row['category'],
                    'brand' => $row['brand'],
                    '__typename' => $row['product__typename'],
                    'gallery' => [],
                    'attributes' => [],
                    'prices' => []
                ];
            }

           // Add gallery image as a simple array of URLs (if not already added)
            if ($row['image_url'] && !in_array($row['image_url'], $products[$productId]['gallery'])) {
                $products[$productId]['gallery'][] = $row['image_url'];
            }

            // Add attribute if it exists and is not already added
            // Add attribute if it exists
            if ($row['attribute_id']) {
                // Find the attribute in the array
                $attributeIndex = array_search($row['attribute_id'], array_column($products[$productId]['attributes'], 'id'));

                if ($attributeIndex === false) {
                    // If attribute does not exist, add it
                    $products[$productId]['attributes'][] = [
                        'id' => $row['attribute_id'],
                        'name' => $row['name'],
                        'type' => $row['type'],
                        'items' => [],
                        '__typename' => $row['attribute__typename'],
                    ];
                    // Update index since we just added the attribute
                    $attributeIndex = array_key_last($products[$productId]['attributes']);
                }

                // Ensure items are unique inside the attribute
                $existingItems = array_column($products[$productId]['attributes'][$attributeIndex]['items'], 'value');
                
                if (!in_array($row['item_value'], $existingItems)) {
                    $products[$productId]['attributes'][$attributeIndex]['items'][] = [
                        'id' => $row['attribute_id'],
                        'displayValue' => $row['item_displayValue'],
                        'value' => $row['item_value'],
                        '__typename' => $row['item__typename']
                    ];
                }
            }


            // Add price if it exists and is not already added
            if ($row['amount'] !== null && !in_array($row['amount'], array_column($products[$productId]['prices'], 'amount'))) {
                $products[$productId]['prices'][] = [
                    'amount' => $row['amount'],
                    'currency' => [
                        'label' => $row['currency_label'], 
                        'symbol' => $row['currency_symbol'], 
                        '__typename' => $row['currency__typename'], 
                    ],
                ];
            }
        }

      // Convert associative array to indexed array
        $products = array_values($products);
        // Log the fetched products for debugging
        // error_log("Fetched products: " . json_encode($products));

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