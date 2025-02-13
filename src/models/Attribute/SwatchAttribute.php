<?php

namespace Src\Models\Attribute;

use Src\Models\Attribute\Attribute;
use Src\Repository\AttributeRepository;

class SwatchAttribute extends Attribute {
    protected $items;

    public function __construct($id, $name, $type, AttributeRepository $repository) {
        parent::__construct($id, $name, $type);
        $this->items = $this->fetchItems($repository);
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