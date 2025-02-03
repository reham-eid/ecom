<?php

namespace src\models\Currency;


class Currency {
  public $label;
  public $symbol;

  public function __construct(array $data) {
      $this->label  = $data['label'] ?? null;
      $this->symbol = $data['symbol'] ?? null;
  }
}

?>