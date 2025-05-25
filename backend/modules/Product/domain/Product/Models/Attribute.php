<?php

namespace app\modules\Product\domain\Product\Models;

/**
 * Атрибут - изменяемое значение конкретно указывающее на объект.
 */
class Attribute
{
    private int $id;

    public function __construct(
        private int $propertyId,
        private string $propertyName,
        private string $value
    )
    {
    }


    public function belongsTo(int $propertyId): bool
    {
        return $this->propertyId === $propertyId;
    }

    public function compareWith(Attribute $attribute): bool
    {
        return $attribute->belongsTo($this->propertyId);
    }

//    public function hasId(int $id): bool
//    {
//        return $this->id === $id;
//    }
}