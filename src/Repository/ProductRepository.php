<?php
namespace Src\Repository;

use PDO;
use Src\Models\Category\AllCategory; 
use Src\Models\Price\Price;
use Src\Models\Currency\Currency;
use Src\Models\Gallery\Gallery;
use Src\Factory\ProductFactory;
use Src\Models\AttributeSet\AllAttributeSet;
use Src\Models\Attribute\Attribute;
// use Src\Repository\AttributeSetRepository;

class ProductRepository{
    private $pdo;
    // private $attributeRepository; 

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
        // $this->attributeRepository = $attributeRepository; 
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $productData = $stmt->fetch(PDO::FETCH_ASSOC);

        // print_r($productData);
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
        // $attributes = $this->attributeRepository->getAttributesByProductId($id);
        // $query = '
        // SELECT   
        //     a.attributes_id,  
        //     a.id AS attribute_id,  
        //     a.product_id,  
        //     a.name AS attribute_name,  
        //     a.type AS attribute_type,  
        //     a.__typename AS attribute_typename,  
        //     i.items_id,  
        //     i.id AS item_id,  
        //     i.displayValue,  
        //     i.value,  
        //     i.__typename AS item_typename  
        // FROM   
        //     attributes a  
        // LEFT JOIN   
        //     items i ON a.attributes_id = i.attribute_id  
        // WHERE
        //     a.product_id = :product_id
        // ORDER BY   
        //     a.attributes_id;';
        $stmt = $this->pdo->prepare("SELECT * FROM attributes WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $id]);
        $attributesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        var_dump($id); 
        echo 'from product reppppppo    ';
        // echo json_encode($attributesData);

        $attributes = [];
        foreach ($attributesData as $attr) {
            $attributeStmt = $this->pdo->prepare("SELECT * FROM items WHERE attribute_id = :attribute_id");
            $attributeStmt->execute(['attribute_id' => $attr['attributes_id']]);
            $attributeData = $attributeStmt->fetch(PDO::FETCH_ASSOC);

            // echo json_encode($attributeData);
            if (!$attributeData) {
                error_log("⚠️ attributes not found " . $attr['attributes_id']);
                $attributeData = null;
            } else {
                $attribute_items  = new Attribute(
                    $this->pdo, 
                    $attributeData['id'], 
                    $attributeData['attribute_id'], 
                    $attributeData['displayValue'] ?? 'N/A',  
                    $attributeData['value'] ?? 'N/A', 
                    $attributeData['__typename'] ?? 'Unknown'
                );
            }

            $attributes[]  = new AllAttributeSet(
                $this->pdo, 
                $attr['id'], 
                $attr['name'], 
                $attr['product_id'],  
                $attribute_items, 
                $attr['type'], 
                $attr['__typename'] 
            );
            

        }
        // echo json_decode($attributes);

        // Debug outside the loop if needed
        // echo 'from ProductFactory 🛠 attributes: ';
        // var_dump($attributes);

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
        $products = ProductFactory::create($this->pdo, $productData, $prices, $gallery, $category, $attributes);
        return $products;
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
