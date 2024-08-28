<?php

namespace app\domain\Product\Models;

use app\domain\Product\Persistance\Snapshots\PropertySnapshot;
use app\domain\Type;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property as PropertyAttribute;
use MongoDB\BSON\ObjectId;

#[DomainModel(mapWith: PropertySnapshot::class)]
class Property
{
    #[PropertyAttribute(defaultMapWith: '_id')]
    private $id = null;
    public function __construct(
        string    $id,
        #[PropertyAttribute(defaultMapWith: 'value')]
        private mixed     $value,
    )
    {
    }

    public function compareWith(Property $property): bool
    {
        return $property->hasId($this->id);
    }

    public function hasId(string $id): bool
    {
        return $this->id === $id;
    }
}