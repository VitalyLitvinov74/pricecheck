<?php

namespace app\domain\Product;

use app\domain\Product\Models\Attribute;
use app\domain\Product\Persistence\Snapshots\ProductSnapshot;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\Property as Prop;
use Doctrine\Common\Collections\ArrayCollection;

#[DomainModel(mapWith: ProductSnapshot::class)]
class Product
{
    #[HasManyModels(
        nestedType: Attribute::class,
        mapWithArrayKey: 'productAttributes',
        mapWithObjectKey: 'attributesSnapshots'
    )]
    /** @var ArrayCollection<int, Attribute> $attributes */
    private ArrayCollection $attributes;

    public function __construct(
        #[Prop(defaultMapWith: 'id')]
        private int|null $id = null
    )
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
        $this->attributes->add($attribute);
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