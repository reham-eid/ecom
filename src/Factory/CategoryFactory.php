<?php

namespace Src\Factory;

// use src\models\ClothingCategory;
// use src\models\Category\AllCategory;

use Src\Models\Category\ClothingCategory;
use Src\Models\Category\TechCategory;
use Src\Models\Category\AllCategory;


class CategoryFactory {
    public static function create($pdo, array $data) {
      echo " from factory ";
      print_r($data);

        switch ($data['name']) {
            case 'clothes':
                $res = new ClothingCategory(
                    $pdo,
                    $data['id'],
                    $data['name'],
                    $data['__typename']
                );
                echo " from factory ClothingCategory >> ";
                print_r($res);
                return $res;
            case 'tech':
                $res = new TechCategory(
                    $pdo,
                    $data['id'],
                    $data['name'],
                    $data['__typename']
                );
                echo " from factory TechCategory >> ";
                print_r($res);
                return $res;

                
            case 'all':
                return new AllCategory(
                    $pdo,
                    $data['id'],
                    $data['name'],
                    $data['__typename']
                );
            default:
                throw new \PDOException("Unknown category: " . $data['name']);
        }
    }
}
?>
