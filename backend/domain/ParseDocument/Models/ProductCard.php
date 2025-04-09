<?php

namespace app\domain\ParseDocument\Models;

use app\domain\ParseDocument\Persistance\Snapshots\ProductCardSnapshot;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\Property;
use Doctrine\Common\Collections\ArrayCollection;

#[DomainModel (mapWith: ProductCardSnapshot::class)]
class ProductCard
{
    /**
     * @param string $parsingVersion
     * @param ArrayCollection<int, CardProperty> $properties
     */
    public function __construct(
        #[Property(mapWithArrayKey: 'parsingVersion')]
        private string $parsingVersion,

        #[HasManyModels(
            nestedType: CardProperty::class,
            mapWithArrayKey: 'properties',
            mapWithObjectKey: 'productCardPropertiesSnapshots'
            /** @see ProductCardSnapshot::$productCardPropertiesSnapshots */
        )]
        private ArrayCollection $properties = new ArrayCollection()) { }

    public function addProperty(string $id, mixed $value): void{
        $this->properties->add(
            new CardProperty($id, $value)
        );
    }
}