<?php

namespace Src\Factory;

use Src\Models\Attribute\TextAttribute;
use Src\Models\Attribute\SwatchAttribute;
use Src\Repository\AttributeRepository;
use PDO;

class AttributeFactory {

    public static function create(PDO $pdo, array $attributesData) {
        echo "<pre> Inside AttributeFactory::create() ";
        print_r($attributesData);
        
        $repository = new AttributeRepository($pdo);
        
        $id = $attributesData['id'] ?? null;
        $name = $attributesData['name'] ?? null;
        $type = $attributesData['type'] ?? null;
        $productId = $attributesData['product_id'] ?? null;  
    
        if (!$id || !$name || !$type || !$productId) {
            throw new \Exception("Invalid attribute data: missing fields.");
        }
    
        $attributeItems = $repository->getAttributesByProductId($productId);
    
        echo "<pre> attributeItems: ";
        print_r($attributeItems);
    
        switch ($type) {
            case 'text':
                return new TextAttribute($pdo, $id, $name, $attributeItems, $type, "AttributeSet");
    
            case 'swatch':
                return new SwatchAttribute($pdo, $id, $name, $attributeItems, $type, "AttributeSet");
    
            default:
                throw new \Exception("Unknown attribute type: " . $type);
        }
    }
    

    
    // public static function create(PDO $pdo, array $attributesData) {
    //     echo "<pre> Inside AttributeFactory::create() ";
    //     print_r($attributesData);
    //     $attributes = [];
    //     $repository = new AttributeRepository($pdo);

    //     foreach ($attributesData as $attributeData) {
    //         $id = $attributeData['id'];
    //         // $name = $attributeData['name'];
    //         // $type = $attributeData['type'];

    //         // جلب جميع العناصر المرتبطة بهذا الـ Attribute
    //         $attributeItems = $repository->getAttributesByProductId($id);

    //         echo "<pre> attributeItems ";
    //         print_r($attributeItems);
            // switch ($type) {
            //     case 'text':
            //         foreach ($attributeItems as $item) {
            //             $attributes[] = new TextAttribute(
            //                 $pdo, 
            //                 $id, 
            //                 $name, 
            //                 $item['value'],  // تمرير قيمة الـ item وليس الكائن كله
            //                 $type, 
            //                 "AttributeSet"
            //             );
            //         }
            //         break;

            //     case 'swatch':
            //         foreach ($attributeItems as $item) {
            //             $attributes[] = new SwatchAttribute(
            //                 $pdo, 
            //                 $id, 
            //                 $name, 
            //                 $item['value'],   
            //                 $type, 
            //                 "AttributeSet"
            //             );
            //         }
            //         break;

            //     default:
            //         throw new \Exception("Unknown attribute type: " . $type);
            // }
    //     }

    //     return $attributes;  
    // }
}
?>
