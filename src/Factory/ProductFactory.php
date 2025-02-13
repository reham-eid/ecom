<?php

namespace Src\Factory;

use Src\Models\Product\ConfigurableProduct;
use Src\Models\Product\SimpleProduct;
use PDO;
use Src\Models\Gallery\Gallery;
use Src\Models\Category\AllCategory;

class ProductFactory {
    public static function create($pdo, $productData, $prices, $gallery, $category, $attributes ) {
        $attributes = is_array($attributes) ? $attributes : []; 
        echo 'from ProductFactory reppppppo   attributes 🥲';
            var_dump($attributes);

            echo json_encode($attributes);
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
                $attributes,
                $productData['__typename']
            );
        }
    }
}


?>