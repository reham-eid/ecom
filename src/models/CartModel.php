<?php

namespace Src\Model;

class Cart
{
    private $id;
    private $userId;
    private $productId;
    private $quantity;

    public function __construct($id, $userId, $productId, $quantity)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    // Getters and setters
    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
}