<?php

namespace models;

use config\Database;
use PDO;

class Order {
    public static function create($user_id, $total_price, $items) {
        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $stmt = $db->prepare("INSERT INTO orders (user_id, total_price, created_at) VALUES (?, ?, NOW())");
            $stmt->execute([$user_id, $total_price]);
            $order_id = $db->lastInsertId();

            $stmtItem = $db->prepare("INSERT INTO order_items (order_id, product_id, quantity, size, color) VALUES (?, ?, ?, ?, ?)");
            foreach ($items as $item) {
                $stmtItem->execute([$order_id, $item['product_id'], $item['quantity'], $item['size'], $item['color']]);
            }

            $db->commit();
            return $order_id;
        } catch (\Exception $e) {
            $db->rollBack();
            return false;
        }
    }
}
