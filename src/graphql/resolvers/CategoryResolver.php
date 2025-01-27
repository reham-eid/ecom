<?php

namespace graphql\resolvers;

use config\Database;
use PDO;

class CategoryResolver
{
    public static function fetchCategories()
    {
        $db = Database::getInstance();
        $query = "SELECT * FROM categories"; 
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetchCategoryById($id)
    {
        $db = Database::getInstance();
        $query = "SELECT * FROM categories WHERE id= :id"; 
        $stmt = $db->prepare($query);
        $stmt->bindParam(":id" , $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}