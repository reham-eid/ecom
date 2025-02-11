<?php

namespace src\models;

class Order {
    protected $pdo;
    protected $id;
    protected $customerId;
    protected $orderDate;
    protected $status;
    protected $items = [];

    public function __construct($pdo, $id, $customerId, $orderDate, $status) {
        $this->pdo = $pdo;
        $this->id = $id;
        $this->customerId = $customerId;
        $this->orderDate = $orderDate;
        $this->status = $status;
    }

    public function addItem(OrderItem $item) {
        $this->items[] = $item;
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getSubtotal();
        }
        return $total;
    }

    public function saveOrder() {
        // Insert order details into the database
        $stmt = $this->pdo->prepare('INSERT INTO orders (id, customer_id, order_date, status) VALUES (:id, :customer_id, :order_date, :status)');
        $stmt->execute([
            'id' => $this->id,
            'customer_id' => $this->customerId,
            'order_date' => $this->orderDate,
            'status' => $this->status
        ]);
        // Insert order items into the database
        foreach ($this->items as $item) {
            $stmt = $this->pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)');
            $stmt->execute([
                'order_id' => $this->id,
                'product_id' => $item->getProduct()->id,
                'quantity' => $item->getQuantity(),
                'price' => $item->getSubtotal() / $item->getQuantity()
            ]);
        }
    }

    public function getDetails() {
        $details = "Order ID: $this->id<br>";
        $details .= "Customer ID: $this->customerId<br>";
        $details .= "Order Date: $this->orderDate<br>";
        $details .= "Status: $this->status<br>";
        $details .= "Total: " . $this->getTotal() . "<br>";
        $details .= "Items:<br>";

        foreach ($this->items as $item) {
            $details .= $item->getDetails() . "<br>";
        }

        return $details;
    }
}
?>

?>
// class Order {
//     public static function create($user_id, $total_price, $items) {
//         $db = Database::getInstance();
//         try {
//             $db->beginTransaction();

//             $stmt = $db->prepare("INSERT INTO orders (user_id, total_price, created_at) VALUES (?, ?, NOW())");
//             $stmt->execute([$user_id, $total_price]);
//             $order_id = $db->lastInsertId();

//             $stmtItem = $db->prepare("INSERT INTO order_items (order_id, product_id, quantity, size, color) VALUES (?, ?, ?, ?, ?)");
//             foreach ($items as $item) {
//                 $stmtItem->execute([$order_id, $item['product_id'], $item['quantity'], $item['size'], $item['color']]);
//             }

//             $db->commit();
//             return $order_id;
//         } catch (\Exception $e) {
//             $db->rollBack();
//             return false;
//         }
//     }
// }
