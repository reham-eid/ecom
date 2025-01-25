<?php

namespace GraphQL\Resolvers;

use Config\Database;
use PDO;

class ProductResolver
{
    public static function fetchProducts()
    {
        $db = Database::getInstance();
        $query = "SELECT * FROM products"; 
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetchProductById($id)
    {
        $db = Database::getInstance();
        $query = "SELECT * FROM products WHERE id = :id"; 
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}