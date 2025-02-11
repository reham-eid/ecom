<?php

namespace Src\Models\Category;  

class TechCategory extends Category
{
  public function getDetails(): array
  {
      return [
          'id' => $this->id,
          'name' => $this->name,
          'type' => $this->__typename
      ];
  }
} 