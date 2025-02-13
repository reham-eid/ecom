<?php

namespace Src\Models\Gallery;

class Gallery {
    protected $pdo;
    // protected $id;
    protected $product_id;
    protected $images;

    public function __construct($pdo , $product_id, array $images) {
        $this->pdo = $pdo;
        // $this->id = $id;
        $this->product_id = $product_id;
        $this->images = $images;
    }

    public function getImages() {
        return $this->images;
    }
}
?>
