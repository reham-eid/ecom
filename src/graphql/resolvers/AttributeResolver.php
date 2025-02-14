<?php

namespace Graphql\Resolvers;

use Config\Database;

use Src\Repository\AttributeSetRepository;

class AttributeResolver
{
    
        // Mock data for attributes
        public static function fetchAttributesByProductId($id) {
            $pdo = Database::getInstance();
            $repo = new AttributeSetRepository($pdo);

            echo "Fetching all Attributes 😉";
            $attributes = $repo->getAttributesByProductId($id);
            // echo "attributes fetched from resolver ";
            // echo json_encode($attributes);
            // var_dump($attributes);
            return  $attributes;
        }
    

    public static function fetchAttributeById($id)
    {
        // Mock data for a single attribute
        return [
            'id' => $id,
            'name' => 'Attribute ' . $id,
            'value' => 'Value ' . $id,
        ];
    }
}