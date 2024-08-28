<?php

namespace app\domain\Product\Models;

use app\domain\Product\Persistance\Snapshots\PropertySnapshot;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property as Prop;

#[DomainModel(mapWith: PropertySnapshot::class)]
class Property
{
    #[Prop(defaultMapWith: 'id')]
    private $pk = null;

    public function __construct(
        #[Prop(
            mapWithArrayKey: 'property_id',
            mapWithObjectKey: 'propertyId'
        )]
        private int    $id,
        #[Prop(
            mapWithArrayKey: 'property_value',
            mapWithObjectKey: 'propertyValue'
        )]
        private mixed  $value,
        #[Prop(
            mapWithArrayKey: 'property_name',
            mapWithObjectKey: 'propertyName'
        )]
        private string $propertyName
    )
    {
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