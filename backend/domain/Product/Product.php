<?php

namespace app\domain\Product;

use app\domain\Product\Models\Attribute;
use app\domain\Product\Models\Property;
use app\domain\Product\Persistance\Snapshots\ProductSnapshot;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\Property as Prop;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @property ArrayCollection<int, Attribute> $properties
 */
#[DomainModel(mapWith: ProductSnapshot::class)]
class Product
{
    #[HasManyModels(
        nestedType: Property::class,
        mapWithArrayKey: 'property_types',
        mapWithObjectKey: 'propertyTypes'
    )]
    private ArrayCollection $availablePropertyTypes;
    
    #[Prop(defaultMapWith: 'id')]
    private $id = null;

    public function __construct(
        #[HasManyModels(
            nestedType: Attribute::class,
            mapWithArrayKey: 'properties'

        )]
        private ArrayCollection $properties = new ArrayCollection(),
    )
    {
    }

    public function attachPropertyWith(int $propertyId, mixed $value): void
    {
        $this->availablePropertyTypes->exists(
            function (Attribute $property){

            }
        )
    }

    public function has(Attribute $property): bool
    {
        return $this->properties->exists(
            function ($key, Attribute $existedProperty) use ($property) {
                return $existedProperty->compareWith($property);
            }
        );
    }
}