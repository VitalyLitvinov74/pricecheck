<?php

namespace app\domain\ProductTemplate\Models;

class Property
{
    private int $id;
    private int $name;
    private ValueType $availableValueType;

    public function __construct(
        PropertyId $id
    )
    {
        $this->name = $id->name;
        $this->id = $id->id;
        $this->availableValueType = $id->type;
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