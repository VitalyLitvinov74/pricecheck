<?php

namespace app\domain\ProductTemplate\Models;

class Property
{
    private int $id;

    public function __construct(
        private string $name,
        private ValueType $availableValueType
    )
    {
    }

    public function hasName(string $name): bool
    {
        return $this->name === $name;
    }

    public function equalsTo(Property $property): bool
    {
        return $property->hasName(
            $this->name
        );
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }

    public function change(ValueType $type): void
    {
        $this->availableValueType = $type;
    }
}