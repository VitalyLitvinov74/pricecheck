<?php

namespace app\domain\Product;

use app\domain\Product\Models\Property;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\Property as Prop;
use Doctrine\Common\Collections\ArrayCollection;
use MongoDB\BSON\ObjectId;

#[DomainModel]
class Product
{
    public function __construct(
        #[HasManyModels(
            nestedType: Property::class,
            mapWithArrayKey: 'properties'
        )]
        private ArrayCollection $properties = new ArrayCollection(),

        #[Prop(defaultMapWith: '_id')]
        private ObjectId $id = new ObjectId() //втоинкремент
    )
    {
    }

    public function add(Property $property): void
    {
        if ($this->has($property)) {
            return;
        }
        $this->properties->add($property);
    }

    public function has(Property $property): bool
    {
        return $this->properties->exists(
            function ($key, Property $existedProperty) use ($property) {
                return $existedProperty->compareWith($property);
            }
        );
    }
}