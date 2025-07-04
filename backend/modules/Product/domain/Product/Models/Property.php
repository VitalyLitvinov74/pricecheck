<?php

namespace app\modules\Product\domain\Product\Models;

use app\domain\Product\Persistence\Snapshots\PropertySnapshot;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property as Prop;

/**
 * Свойство - значение описывающее объект, но присущее любому колличеству объектов.
 */
#[DomainModel(mapWith: PropertySnapshot::class)]
class Property
{
    #[Prop(
        defaultMapWith: 'id'
    )]
    private int $id;

    #[Prop(
        defaultMapWith: 'name'
    )]
    private string $name;

    private function __construct()
    {
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