<?php

namespace Src\Models\Attribute;

use Src\Models\Attribute\Attribute;
use Src\Repository\AttributeRepository;

class TextAttribute extends Attribute {
    protected $items;

    public function __construct($pdo, $id, $name, AttributeRepository $items, $type, $__typename) {
        parent::__construct($pdo, $id, $name, $items, $type, $__typename);
        $this->pdo = $pdo;
        $this->items = $this->fetchItems($items);
    }

    protected function fetchItems(AttributeRepository $repository) {
        $itemsData = $repository->getAttributesByProductId($this->id);
        return array_map(fn($item) => [
            "displayValue" => $item['display_value'],
            "value" => $item['value'],
            "id" => $item['id'],
            "__typename" => $item['__typename'] 
        ], $itemsData);
    }

    public function getItems() {
        return $this->items;
    }
}


?>