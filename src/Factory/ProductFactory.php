<?php

namespace Src\Factory;

use Src\Models\Product\ConfigurableProduct;
use Src\Models\Product\SimpleProduct; 

class ProductFactory {
    public static function create($pdo, $productData, $prices, $gallery, $category, $attributes ) {
            // echo 'from ProductFactory reppppppo   attributes 🥲';
            // var_dump($attributes);
            // if (!is_array($attributes)) {
            //     throw new \Exception("Attributes must be an array, but got: " . gettype($attributes));
            // }
            // echo json_encode($attributes);
            // $attributes = is_array($attributes) ? $attributes : [];

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
                $attributes = [],   
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
                $attributes = [],
                $productData['__typename']
            );
        }
    }
}


?>