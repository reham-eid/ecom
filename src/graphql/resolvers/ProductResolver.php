<?php

namespace graphql\resolvers;

use config\Database;
use PDO;

class ProductResolver
{
    public static function fetchProducts()
    {
        $db = Database::getInstance();
        // $query = "SELECT * FROM products"; 
        $query = "
    SELECT 
        p.*, 
        g.image_url AS gallery_image, 
        pr.amount AS price_amount
    FROM 
        products p
    LEFT JOIN gallery g ON p.id = g.product_id
    LEFT JOIN prices pr ON p.id = pr.product_id
";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //     $query = "
    //     SELECT 
    // p.id AS product_id,
    // p.name AS product_name,
    // p.description AS product_description,
    // p.inStock AS in_stock,
    // p.category AS category,
    // p.brand AS brand,
    // pr.amount AS price_amount,
    // pr.currency_label AS price_currency_label,
    // pr.currency_symbol AS price_currency_symbol,
    // g.image_url AS gallery_image,
    // a.attribute_name AS attribute_name,
    // a.attribute_type AS attribute_type,
    // ai.display_value AS attribute_display_value,
    // ai.value AS attribute_value
    // FROM products p
    // LEFT JOIN prices pr ON p.id = pr.product_id
    // LEFT JOIN gallery g ON p.id = g.product_id
    // LEFT JOIN attributes a ON p.id = a.product_id
    // LEFT JOIN items ai ON a.id = ai.attribute_id
    // ORDER BY p.id, a.id, ai.id;

    // ";


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