<?php

namespace Src\Repository;

use PDO;

use Src\Factory\AttributeSetFactory;
class AttributeSetRepository {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAttributesByProductId($productId) {
        
        static $callCount = 0;
        $callCount++;
    
        if ($callCount > 10) { 
            throw new \Exception("Infinite recursion detected in getAttributesByProductId()");
        }
    
        // echo "getAttributesByProductId() called: $callCount times\n";

    //     $stmt = $this->pdo->prepare("  
    //     SELECT   
    //         a.attributes_id,  
    //         a.id AS attribute_id,  
    //         a.product_id,  
    //         a.name,  
    //         a.type,  
    //         a.__typename,  
    //         i.items_id,  
    //         i.id AS item_id,  
    //         i.displayValue,  
    //         i.value,  
    //         i.__typename AS item_typename  
    //     FROM   
    //         attributes a  
    //     LEFT JOIN   
    //         items i ON a.attributes_id = i.attribute_id  
    //     WHERE  
    //         a.product_id = :product_id  
    //     ORDER BY   
    //         a.attributes_id LIMIT 0, 25;  
    // ");  
    // $stmt->bindParam(':product_id', $productId);  
    // $stmt->execute();
    $stmt = $this->pdo->prepare("SELECT * FROM attributes WHERE product_id = :product_id");
    $stmt->execute(['product_id' => $productId]);
    $attributesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
json_encode($attributesData);
    $attributes = [];
    foreach ($attributesData as $attr) {
        $attributeStmt = $this->pdo->prepare("SELECT * FROM items WHERE attribute_id = :attribute_id");
        $attributeStmt->execute(['attribute_id' => $attr['attributes_id']]);
        $attribute = $attributeStmt->fetch(PDO::FETCH_ASSOC);
        $attributes[] = AttributeSetFactory::create($this->pdo, $attribute);
        
    }

//         $attributesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         echo "Total Attributes Retrieved: " . count($attributesData) . "\n";
// echo "Total Attributes  sasasa ";
//     if (!$attributesData) {
//         throw new \Exception("No attributes found for product_id: " . $productId);
//     }
    // $attributes = [];

    // foreach ($attributesData as $attribute) {
    //     $attributes[] = AttributeSetFactory::create($this->pdo, $attribute);
    // }

json_encode($attributes);
        return $attributes;

    }
}

?>
