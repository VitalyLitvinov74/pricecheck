<?php

namespace app\domain\Product\Models;

class Property
{
    public function __construct(private string $key, private mixed $value, private ValueType $valueType)
    {
    }

    public function hasSameName(Property $property): bool
    {
        return $property->hasName($this->key);
    }

    public function hasName(string $name): bool
    {
        return $this->key === $name;
    }
}