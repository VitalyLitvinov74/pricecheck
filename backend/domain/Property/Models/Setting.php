<?php

namespace app\domain\Property\Models;

use app\domain\Property\Persistence\snapshots\SettingSnapshot;
use app\domain\Property\Property;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property as Prop;

#[DomainModel (mapWith: SettingSnapshot::class)]
class Setting
{
    #[Prop(
        defaultMapWith: 'id'
    )]
    private int|null $id = null;
    public function __construct(
        #[Prop(
            mapWithArrayKey: 'property_id',
            mapWithObjectKey: 'propertyId'
        )]
        private int $propertyId,
        #[Prop(
            mapWithArrayKey: 'setting_type_id',
            mapWithObjectKey: 'type',
            typecast: PropertySettingType::class
        )]
        private PropertySettingType $type,
    )
    {
    }

    public function belongsTo(Property $property): bool{
        return $property->hasId($this->propertyId);
    }

    public function is(PropertySettingType $type): bool{
        return $this->type === $type;
    }

    public function compareWith(Setting $setting): bool{
        return $setting->is($this->type);
    }
}