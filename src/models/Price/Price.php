<?php

namespace src\models;

class Price {
    protected $pdo;
    protected $id;
    protected $product_id;
    protected $amount;
    protected $currency;
    protected $__typename;

    public function __construct($pdo, $id, $product_id, $amount, $currency, $__typename) {
        $this->pdo = $pdo;
        $this->id = $id;
        $this->product_id = $product_id;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->__typename = $__typename;
    }

    public function getDetails() {
        return "Price: $this->amount $this->currency";
    }
}
?>
