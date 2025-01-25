<?php

namespace GraphQL\Resolvers;

class AttributeResolver
{
    public static function fetchAttributes()
    {
        // Mock data for attributes
        return [
            [
                'id' => '1',
                'name' => 'Attribute 1',
                'value' => 'Value 1',
            ],
        ];
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