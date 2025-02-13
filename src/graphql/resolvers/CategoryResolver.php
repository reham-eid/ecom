<?php

namespace Graphql\Resolvers;

use Config\Database;
use Src\Repository\CategoryRepository;

class CategoryResolver
{
    // public static function fetchCategories()
    // {
    //     try {
    //         $db = Database::getInstance();
    //         $query = "
    //             SELECT 
    //                 id,
    //                 name,
    //                 __typename
    //             FROM
    //                 categories"; 

    //         $stmt = $db->prepare($query);
    //         if (!$stmt->execute()) {
    //             throw new \Exception("Database query failed.");
    //         }
    //         // $stmt->execute();
    //         $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //         if (!$rows) {
    //             http_response_code(404);
    //             return ["error" => "No Categories found!"];
    //         }

    //         $categories = [];
    //         foreach($rows as $row){
    //             $categoryId = $row['id'];
    //             if (!isset($categories[$categoryId])) {
    //                 $categories[$categoryId] = [
    //                     'name' => $row['name'],
    //                     '__typename' => $row['__typename']
    //                 ];
    //             }
    //         }

    //         http_response_code(200);
    //         return array_values($categories);

    //     } 
    //     catch (\Exception $e) {
    //         http_response_code(500);
    //         return ["error" => $e->getMessage()];
    //     }
    // }

    // class GetAllCategoriesResolver {
        public static function GetAllCategories() {
            $pdo = Database::getInstance();
            $repo = new CategoryRepository($pdo);
            // echo "Fetching all categories";
            $categories = $repo->fetchAllCategories();
            // echo "Categories fetched from resolver ";
            // echo json_encode($categories);
            return  $categories;
        }
    // }
    
    // Resolver for fetching clothing categories
    // class GetClothesResolver {
        public static function GetClothes() {
            $pdo = Database::getInstance();
            $repo = new CategoryRepository($pdo);
            return $repo->fetchCategoriesByName('clothes');
        }
    // }
    
    // Resolver for fetching tech categories
    // class GetTechResolver {
        public static function GetTech() {
            $pdo = Database::getInstance();
            $repo = new CategoryRepository($pdo);
            return $repo->fetchCategoriesByName('tech');
        }
    // }

    // public static function fetchCategoryById($id)
    // {
    //     $db = Database::getInstance();
    //     $query = "SELECT * FROM categories WHERE id= :id"; 
    //     $stmt = $db->prepare($query);
    //     $stmt->bindParam(":id" , $id , PDO::PARAM_STR);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
}