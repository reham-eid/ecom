<?php

namespace Src\Factory;

use Src\Models\Product\ConfigurableProduct;
use Src\Models\Product\SimpleProduct;
use Src\Repository\AttributeRepository;

class ProductFactory {
    public static function create($pdo, $productData, $prices, $gallery, $category) {
        $attributeRepository = new AttributeRepository($pdo);
        $attributes = $attributeRepository->getAttributesByProductId($productData['id']);

        if (!empty($attributes)) {
            return new ConfigurableProduct(
                $pdo,
                $productData['id'],
                $productData['name'],
                $productData['inStock'],
                $productData['description'],
                $category,
                $prices,
                $gallery,
                $productData['brand'],
                $attributes,   
                $productData['__typename']
            );
        } else {
            return new SimpleProduct(
                $pdo,
                $productData['id'],
                $productData['name'],
                $productData['inStock'],
                $productData['description'],
                $category,
                $prices,
                $gallery,
                $productData['brand'],
                $productData['__typename']
            );
        }
    }
}


?>