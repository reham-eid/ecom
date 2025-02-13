<?php

namespace Graphql\Resolvers;

use Config\Database;
use PDO;
use Exception;

use Src\Repository\ProductRepository;
// use Src\Repository\AttributeSetRepository;
// use Src\Models\AttributeSet\TextAttribute;


class ProductResolver
{
    public static function fetchProducts()
    {
        try {
            $db = Database::getInstance();
            $query = "
                SELECT DISTINCT 
                    p.id,
                    p.name,
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
                    pc.__typename AS currency__typename,
                    pcat.name  AS category_name
                FROM
                    products p
                LEFT JOIN
                    categories pcat ON p.id = pcat.product_id
                LEFT JOIN
                    gallery pg ON p.id = pg.product_id
                LEFT JOIN
                    attributes pa ON p.id = pa.product_id
                LEFT JOIN
                    items ai ON pa.id = ai.attribute_id
                LEFT JOIN
                    prices pp ON p.id = pp.product_id
                LEFT JOIN
                    currency pc ON pp.currency = pc.label;
            ";

            $stmt = $db->prepare($query);
            if (!$stmt->execute()) {
                throw new Exception("Database query failed.");
            }

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$rows) {
                http_response_code(404);
                return ["error" => "No products found!"];
            }

            $products = [];
            foreach ($rows as $row) {
                // product class table 
                $productId = $row['id'];

                // Initialize the product if it doesn't exist
                if (!isset($products[$productId])) {
                    $products[$productId] = [
                        'id' => $row['id'], // product.setName 
                        'name' => $row['name'],
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

                // Add attribute if it exists
                if ($row['attribute_id']) {
                    $attributeIndex = array_search($row['attribute_id'], array_column($products[$productId]['attributes'], 'id'));

                    if ($attributeIndex === false) {
                        $products[$productId]['attributes'][] = [
                            'id' => $row['attribute_id'],
                            'name' => $row['name'],
                            'type' => $row['type'],
                            'items' => [],
                            '__typename' => $row['attribute__typename'],
                        ];
                        $attributeIndex = array_key_last($products[$productId]['attributes']);
                    }

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

            http_response_code(200); // Success
            return array_values($products);

        } catch (\Exception $e) {
            http_response_code(500); // Internal Server Error
            return ["error" => $e->getMessage()];
        }
    }

    public static function fetchProductById($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $product= $stmt->fetch(PDO::FETCH_ASSOC);

        echo(print_r($product));
        if ($product) {
            return [
                'id' => $product['id'],
                'name' => $product['name'], // Map database field to GraphQL field
                'inStock' => $product['inStock'],
                'description' => $product['description'],
                'category' => $product['category'],
                'brand' => $product['brand'],
                'gallery' => [],
                'attributes' => [],
                'prices' => []
                ];

            // Add gallery image as a simple array of URLs (if not already added)
            if ($row['image_url'] && !in_array($row['image_url'], $products[$productId]['gallery'])) {
                $products[$productId]['gallery'][] = $row['image_url'];
            }

            // Add attribute if it exists
            if ($row['attribute_id']) {
                $attributeIndex = array_search($row['attribute_id'], array_column($products[$productId]['attributes'], 'id'));

                if ($attributeIndex === false) {
                    $products[$productId]['attributes'][] = [
                        'id' => $row['attribute_id'],
                        'name' => $row['name'],
                        'type' => $row['type'],
                        'items' => [],
                        '__typename' => $row['attribute__typename'],
                    ];
                    $attributeIndex = array_key_last($products[$productId]['attributes']);
                }

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
    }

    public static function GetAllProducts() {
        $pdo = Database::getInstance();
        // $attributes= new AttributeSetRepository($pdo);
        $repo = new ProductRepository($pdo);
        $products = $repo->findAll();
        return $products;
    }

    public static function GetProduct($productId) {
        $pdo = Database::getInstance();
        // $attributes= new AttributeSetRepository($pdo);
        $repo = new ProductRepository($pdo );
        $products = $repo->findById($productId);
        return $products;
    }

    public static function GetProductsByCategory($categoryId) {
        $pdo = Database::getInstance();
        // $attributes= new TextAttribute($pdo);
        // echo 'from  resolverr ';
        // print_r($attributes );
        $repo = new ProductRepository($pdo);
        $products = $repo->getProductsByCategory($categoryId);
        return $products;
    }
}

?>
