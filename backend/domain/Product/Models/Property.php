<?php

namespace app\domain\Product\Models;

/**
 * Свойство - значение описывающее объект, но присущее любому колличеству объектов.
 */
class Property
{
    private string $name;
    private int $id;

    private function __construct()
    {
    }

    public function hasName(string $name): bool
    {
        return $this->name === $name;
    }

    public function canAttachTo(Attribute $attribute): bool
    {
        return $attribute->belongsTo($this);
    }

    public function compareWith(Property $property): bool
    {
        return $property->hasId($this->id);
    }

    public function hasId(int $id): bool
    {
        return $this->id === $id;
    }
}