<?php

namespace src\models\Category;


class AllCategory extends Category {
  public function getDetails(): array {
      return [
          'id' => $this->id,
          'name' => $this->name,
          'type' => $this->__typename,
      ];
  }
}

?>
