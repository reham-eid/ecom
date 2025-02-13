<?php

namespace Src\Repository;

use PDO;

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
    
        echo "getAttributesByProductId() called: $callCount times\n";

        $stmt = $this->pdo->prepare("SELECT * FROM attributes WHERE product_id = :product_id LIMIT 5");
        $stmt->execute(['product_id' => $productId]);

        echo "Fetching attributes one by one...\n";

        $attributes = [];
    
        while ($attribute = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $attributes[] = $attribute; ;
        }
        unset($attribute);  
        return $attributes;

    }

        // $attributesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // echo "Total Attributes Retrieved: " . count($attributesData) . "\n";

        // // print_r($attributesData);
        // if (!$attributesData) {
        //     throw new \Exception("No attributes found for product_id: " . $productId);
        // }
        // $attributes = [];

        // foreach ($attributesData as $attribute) {
        //     $attributes[] = AttributeSetFactory::create($this->pdo, $attribute);
        // }

}

?>
