<?php

namespace Src\Models\Currency;

class Currency {
    protected $pdo;
    protected $label;
    protected $symbol;
    protected $__typename;

    public function __construct($pdo, $label, $symbol, $__typename) {
        $this->pdo = $pdo;
        $this->label = $label;
        $this->symbol = $symbol;
        $this->__typename = $__typename;
    }

      // Getters
    public function getLabel() { return $this->label; }
    public function getSymbol() { return $this->symbol; }
    public function getTypename() { return $this->__typename; }

    public function getDetails() {
        return "{$this->label} ({$this->symbol})";
    }
}
?>

