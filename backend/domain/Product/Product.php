<?php

namespace app\domain\Product;

use app\domain\Product\Models\Property;
use app\domain\Product\Persistance\Snapshots\ProductSnapshot;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\Property as Prop;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @property ArrayCollection<int, Property> $properties
 */
#[DomainModel(mapWith: ProductSnapshot::class)]
class Product
{
    #[Prop(defaultMapWith: 'id')]
    private $id = null;

    public function __construct(
        #[HasManyModels(
            nestedType: Property::class,
            mapWithArrayKey: 'properties'

        )]
        private ArrayCollection $properties = new ArrayCollection(),
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