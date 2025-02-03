<?php
namespace src\models\Price;

use src\models\Currency\Currency;

class Price {
    public $amount;
    public $currency; // Currency object.

    public function __construct(array $data) {
        $this->amount   = $data['amount'] ?? 0;
        if (isset($data['currency'])) {
            $this->currency = new Currency($data['currency']);
        }
    }

    public function __toString() {
        return $this->currency->symbol . $this->amount;
    }
}
?>