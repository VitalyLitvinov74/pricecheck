<?php

namespace app\domain\Product\Models;

use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property as PropertyAttribute;
#[DomainModel]
class Property
{
    public function __construct(
        #[PropertyAttribute(defaultMapWith: 'name')]
        private string    $name,
        #[PropertyAttribute(defaultMapWith: 'value')]
        private mixed     $value,
        #[PropertyAttribute(defaultMapWith: 'type', typecast: ValueType::class)]
        private ValueType $valueType
    )
    {
    }

    public function hasSameName(Property $property): bool
    {
        return $property->hasName($this->name);
    }

    public function hasName(string $name): bool
    {
        return $this->name === $name;
    }
}