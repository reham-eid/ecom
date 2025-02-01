<?php

namespace GraphQL\Resolvers;

use config\Database;
use Exception;
use PDO;

class OrderResolver
{

    /**
     * Constructor: Initialize database connection
     */

    /**
     * Handles the order placement logic
     * 
     * @param array $args
     * @return array
     */
    public static function placeOrder(array $args): array
    {
        try {
            $db = Database::getInstance();

            $input = $args['input'];

            // Extract order details
            $userId = $input['user_id'];
            $totalPrice = $input['total_price'];
            $items = $input['items'];

            // Insert order into database
            $stmt = $db->prepare("
                INSERT INTO orders (user_id, total_price, status) 
                VALUES (:user_id, :total_price, 'pending')
            ");
            $stmt->execute([
                ':user_id' => $userId,
                ':total_price' => $totalPrice
            ]);

            echo(print_r($stmt));
            // Get the last inserted order ID
            $orderId = $db->lastInsertId();

            // Insert order items
            $itemStmt = $db->prepare("
                INSERT INTO order_items (order_id, product_id, quantity) 
                VALUES (:order_id, :product_id, :quantity)
            ");

            foreach ($items as $item) {
                $itemStmt->execute([
                    ':order_id' => $orderId,
                    ':product_id' => $item['product_id'],
                    ':quantity' => $item['quantity']
                ]);
            }

            return [
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $orderId
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Order failed: ' . $e->getMessage(),
                'order_id' => null
            ];
        }
    }
}

?>