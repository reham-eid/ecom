<?php

namespace Src\Models\AttributeSet; 

// use Src\Repository\AttributeSetRepository; 
use Src\Models\Attribute\Attribute; 

abstract class AttributeSet {
  protected $pdo;
  protected $id;
  protected $product_id;
  protected $name;
  protected $items ;
  protected $type;
  protected $__typename;

  public function __construct($pdo, $id, $name, $product_id , Attribute $items, $type, $__typename) {
      $this->pdo = $pdo;
      $this->id = $id;
      $this->product_id = $product_id;
      $this->name = $name;
      $this->items = $items;
      $this->type = $type;
      $this->__typename = $__typename;
  }

      // Getters
      public function getId() { return $this->id; }
      public function getProduct_id() { return $this->product_id; }
      public function getName() { return $this->name; }
      public function getItems() { return $this->items; }
      public function getType() { return $this->type; }
      public function getTypename() { return $this->__typename; }

  

  // protected function fetchItems() {
  //   static $callDepth = 0;
  //   $callDepth++;

  //   if ($callDepth > 10) {  
  //       throw new \Exception("Infinite loop detected in fetchItems()!");
  //   }

  //   // ✅ جلب البيانات من قاعدة البيانات
  //   $stmt = $this->pdo->prepare("SELECT * FROM attributes WHERE product_id = :product_id LIMIT 5");
  //   $stmt->execute(['product_id' => $this->product_id]);
  //   $itemsData = $stmt->fetchAll(\PDO::FETCH_ASSOC); // ✅ تأكد من تعيين القيم هنا

  //   // ✅ تحويل البيانات إلى كائنات `Attribute`
  //   $this->items = array_map(fn($item) => new Attribute(
  //       $this->pdo,
  //       $item['id'] ?? '',
  //       $item['attribute_id'] ?? '',
  //       $item['display_value'] ?? '',
  //       $item['value'] ?? '',
  //       $item['__typename'] ?? ''
  //   ), $itemsData);

  //   return $this->items;
  // }


  // protected function fetchItems(AttributeSetRepository $repository) {

  //   static $callDepth = 0;
  //   $callDepth++;

  //   if ($callDepth > 10) {  
  //       throw new \Exception("Infinite loop detected in fetchItems()!");
  //   }
  //     $itemsData = $repository->getAttributesByProductId($this->product_id);

  //     $this->items = array_map(fn($item) => new Attribute(
  //       $this->pdo,
  //       $item['id'] ?? '',
  //       $item['attribute_id'] ?? '',
  //       $item['display_value'] ?? '',
  //       $item['value'] ?? '',
  //       $item['__typename'] ?? ''
  //   ), $itemsData);

  //     return $this->items = $itemsData;
  // }

  
}
// public function getItems() {
//   return array_map(fn($item) => [
//       "id" => $item->getId(),
//       "displayValue" => $item->getDisplayValue(),
//       "value" => $item->getValue(),
//       "__typename" => $item->getTypename(),
//   ], $this->items);
// }
  // abstract public function getItems();
  
  // abstract public function getValue();

// class SizeAttribute extends Attribute {
//   public function getValue() {
//       return "Size: $this->name";
//   }
// }

// class ColorAttribute extends Attribute {
//   public function getValue() {
//       return "Color: $this->name";
//   }
// }

?>

