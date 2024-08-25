<?php

namespace app\domain\Product\Models;

use app\domain\Type;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property as PropertyAttribute;
use MongoDB\BSON\ObjectId;

#[DomainModel]
class Property
{
    #[PropertyAttribute(defaultMapWith: '_id')]
    private ObjectId $id;
    public function __construct(
        string    $id,
        #[PropertyAttribute(defaultMapWith: 'value')]
        private mixed     $value,
    )
    {
        $this->id = new ObjectId($id);
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