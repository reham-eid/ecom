<?php

namespace src\models\ProductGallery;

class ProductGallery {
  protected $product_id;
  protected $image_url;

  public function __construct($product_id,$image_url) {
      $this->product_id = $product_id;
      $this->image_url = $image_url;
  }

  public function getImageUrl() {
    return $this->image_url;
}

}

?>