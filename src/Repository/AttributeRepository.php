<?php

namespace Src\Repository;

use PDO;

use Src\Factory\AttributeFactory;

class AttributeRepository {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAttributesByProductId($productId) {
        $stmt = $this->pdo->prepare("SELECT * FROM attributes WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        $attributesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // echo "<pre> attributesData ";
        // print_r($attributesData);
        if (!$attributesData) {
            throw new \Exception("No attributes found for product_id: " . $productId);
        }
        $attributes = [];

        foreach ($attributesData as $attributeData) {
            if (!is_array($attributeData)) {
                throw new \Exception("Expected array, but received: " . gettype($attributeData));
            }
            $attributes[] = AttributeFactory::create($this->pdo, $attributeData);
        }

        echo "<pre> attributes ";
        print_r($attributes);
        return $attributesData;
    }
}

?>
