<?php
namespace Src\Repository;

use PDO;
use Src\Models\Category\AllCategory;
use Src\Models\Price\Price;
use Src\Models\Currency\Currency;
use Src\Models\Gallery\Gallery;
use Src\Factory\ProductFactory;

class ProductRepository{
    private $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $productData = $stmt->fetch(PDO::FETCH_ASSOC);

        print_r($productData);
        if (!$productData) {
            http_response_code(404);
            return ["error" => "No products found!"]; // No product found
        }

        // Fetch Category
        $categoryStmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = :id");
        $categoryStmt->execute(['id' => $productData['category']]);
        $categoryData = $categoryStmt->fetch(PDO::FETCH_ASSOC);

        $category = new AllCategory(
            $this->pdo,
            $categoryData['id'],
            $categoryData['name'],
            $categoryData['__typename'],
        );


        // Fetch Gallery 
        $stmt = $this->pdo->prepare('SELECT image_url FROM gallery WHERE product_id = :product_id');
        $stmt->execute(['product_id' => $id]);
        $galleryData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $galleryImages = array_map(fn($row) => $row['image_url'], $galleryData);

        $gallery = new Gallery($this->pdo, $id, $galleryImages) ;

        // foreach ($galleryData as $image) {
        //     $gallery[] = new Gallery($this->pdo, $image['id'], $id, $image['image_url']);
        // }
        
        // Fetch Attributes
        // $stmt = $this->pdo->prepare("SELECT * FROM attributes WHERE product_id = :product_id");
        // $stmt->execute(['product_id' => $id]);
        // $attributesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // $attributes = [];
        // foreach ($attributesData as $attr) {
        //     $attributes[] = new Attribute(
        //         $this->pdo, 
        //         $attr['id'], 
        //         $attr['name'], 
        //         $attr['type'], 
        //         $attr['__typename']
        //     );
        // }

        // Fetch prices
        $stmt = $this->pdo->prepare("SELECT * FROM prices WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $id]);
        $pricesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // print_r($pricesData);
        $prices = [];
        foreach ($pricesData as $price) {
            $currencyStmt = $this->pdo->prepare("SELECT * FROM currency WHERE label = :label");
            $currencyStmt->execute(['label' => $price['currency']]);
            $currencyData = $currencyStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$currencyData) {
                error_log("⚠️ currency not found " . $price['currency']);
                $currency = null;
            } else {
                $currency = new Currency($this->pdo, $currencyData['label'], $currencyData['symbol'], $currencyData['__typename']);
            }
            $amount = $price['amount'] ?? 0;
            // $currency = new Currency($this->pdo, $currencyData['label'], $currencyData['symbol'], $currencyData['__typename']);
            $prices[] = new Price($this->pdo, $price['id'], $id, $amount, $currency, $price['__typename']);
        }
        // var_dump($prices); die();
        return ProductFactory::create($this->pdo, $productData, $prices, $gallery , $category);
    }

    public function findAll() {
        $stmt = $this->pdo->query("SELECT * FROM products");
        $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$productsData) {
            http_response_code(404);
            return ["error" => "No products found!"]; // No product found
        }

        $products = [];
        foreach ($productsData as $productData) {
            $products[] = $this->findById($productData['id']);
        }

        return $products;
    }

    public function getProductsByCategory($categoryId) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE category = :categoryId");
        $stmt->execute(['categoryId' => $categoryId]);
        $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if (!$productsData) {
            http_response_code(404);
            return ["error" => "No products found for this category!"];
        }
    
        $products = [];
        foreach ($productsData as $productData) {
            $products[] = $this->findById($productData['id']);
        }
    
        return $products;
    }
    
}
?>
