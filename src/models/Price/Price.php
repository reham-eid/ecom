<?php

namespace Src\Models\Price;

use Src\Models\Currency\Currency;

class Price {
    protected $pdo;
    protected $id;
    protected $product_id;
    protected $amount;
    protected $currency;
    protected $__typename;

    public function __construct($pdo, $id, $product_id, $amount, Currency $currency, $__typename) {
        $this->pdo = $pdo;
        $this->id = $id;
        $this->product_id = $product_id;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->__typename = $__typename;
    }

      // Getters
    public function getId() { return $this->id; }
    public function getAmount() { return $this->amount; }
    public function getTypename() { return $this->__typename; }
    public function getCurrency() { return $this->currency; }

    public function getDetails() {
        return "Price: {$this->amount} {$this->currency->getSymbol()} ({$this->currency->getLabel()})";
    }
}
?>
