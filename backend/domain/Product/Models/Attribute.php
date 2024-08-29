<?php

namespace app\domain\Product\Models;

use app\domain\Product\Persistance\Snapshots\PropertySnapshot;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasOneModel;
use app\libs\ObjectMapper\Attributes\Property as Prop;

#[DomainModel(mapWith: PropertySnapshot::class)]
class Attribute
{
    #[Prop(defaultMapWith: 'id')]
    private $pk = null;

    public function __construct(
        #[HasOneModel(
            nestedType:  Property::class,
            defaultMapWith: 'property_type',
            mapWithObjectKey: 'propertyType'
        )]
        private Property $type,

        #[Prop(
            mapWithArrayKey: 'property_value',
            mapWithObjectKey: 'propertyValue'
        )]
        private mixed    $value,

    )
    {
    }

    public function compareWith(Attribute $property): bool
    {
        return $property->hasId($this->id);
    }

    public function hasId(int $id): bool
    {
        return $this->type->hasId($id);
    }
}