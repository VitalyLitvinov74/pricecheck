<?php

namespace app\domain\Product\Models;

use app\domain\Product\Persistence\Snapshots\PropertySnapshot;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasOneModel;
use app\libs\ObjectMapper\Attributes\Property as Prop;

/**
 * Атрибут - изменяемое значение конкретно указывающее на объект.
 */
#[DomainModel(mapWith: PropertySnapshot::class)]
class Attribute
{
    #[Prop(defaultMapWith: 'id')]
    private $id = null;

    public function __construct(
        #[HasOneModel(
            nestedType:  Property::class,
            defaultMapWith: 'property',
            mapWithObjectKey: 'property'
        )]
        private Property $property,

        #[Prop(
            mapWithArrayKey: 'value',
            mapWithObjectKey: 'value'
        )]
        private mixed    $value,

    )
    {
    }


    public function belongsTo(Property $property): bool
    {
        return $property->compareWith($this->property);
    }

    public function compareWith(Attribute $attribute): bool
    {
        return $attribute->hasId($this->id);
    }

    public function hasId(int|null $id): bool
    {
        return $this->id === $id;
    }
}