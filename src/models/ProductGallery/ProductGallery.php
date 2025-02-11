<?php

namespace src\models;

class Gallery {
    protected $pdo;
    protected $id;
    protected $product_id;
    protected $image_url;

    public function __construct($pdo, $id, $product_id, $image_url) {
        $this->pdo = $pdo;
        $this->id = $id;
        $this->product_id = $product_id;
        $this->image_url = $image_url;
    }

    public function getImage() {
        return $this->image_url;
    }
}
?>
