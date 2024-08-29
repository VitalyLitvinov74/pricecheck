<?php

namespace app\domain\Product;

use app\domain\Product\Models\Attribute;
use app\domain\Product\Models\Property;
use app\domain\Product\Persistence\Snapshots\ProductSnapshot;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\Property as Prop;
use Doctrine\Common\Collections\ArrayCollection;

#[DomainModel(mapWith: ProductSnapshot::class)]
class Product
{
    #[HasManyModels(
        nestedType: Property::class,
        mapWithArrayKey: 'available_properties',
        mapWithObjectKey: 'availableProperties'
    )]
    /** @var  ArrayCollection<int, Property> $availableProperties */
    private ArrayCollection $availableProperties;
    
    #[Prop(defaultMapWith: 'id')]
    private $id = null;

    #[HasManyModels(
        nestedType: Attribute::class,
        mapWithArrayKey: 'attributes'
    )]
    /** @var ArrayCollection<int, Attribute> $attributes */
    private ArrayCollection $attributes;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
    }

    public function attachWith(Attribute $attribute): void
    {
        $existedSameAttribute = $this->attributes->findFirst(
            function($key, Attribute $existedAttribute) use ($attribute){
                return $attribute->compareWith($existedAttribute);
            }
        );
        if($existedSameAttribute !== null){
            $this->attributes->removeElement($existedSameAttribute);
            $this->attributes->add($attribute);
            return;
        }
        foreach ($this->availableProperties as $availableProperty){
            if($attribute->belongsTo($availableProperty)){
                $this->attributes->add($attribute);
                return;
            }
        }
        $existAvailableProperty = $this->availableProperties->exists(
            function($key, Property $property) use ($attribute){
                return $property->canAttachTo($attribute);
            }
        );
        if($existAvailableProperty){
            $this->attributes->add($attribute);
        }
    }

    public function has(Attribute $attribute): bool
    {
        return $this->attributes->exists(
            function ($key, Attribute $existedAttribute) use ($attribute) {
                return $existedAttribute->compareWith($attribute);
            }
        );
    }
}