<?php

namespace Src\Models\Product;

use Src\Models\Product\Product;

class SimpleProduct extends Product {

  public function getDetails(): array
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'price' => $this->prices,
      'category' => $this->category,
      'brand' => $this->brand,
      'inStock' => $this->inStock,
      'description' => $this->description,
      'gallery' => $this->gallery->getImages(),
  ];
  }
}

?>
