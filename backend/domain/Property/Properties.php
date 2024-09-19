<?php

namespace app\domain\Property;

use app\domain\Property\Models\Property;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use Doctrine\Common\Collections\ArrayCollection;

#[DomainModel]
class Properties
{
    #[HasManyModels(
        nestedType: Property::class,
        defaultMapWith: 'collection'
    )]
    /**
     * @var ArrayCollection<int, Property>
     */
    private ArrayCollection $collection;
    private function __construct()
    {
    }

    public function add(string $name, string $type): self
    {
        $existed = $this->collection->exists(function($key, Property $existedProperty) use($name){
           return $existedProperty->hasName($name);
        });
        if($existed){
            return $this;
        }
        $this->collection->add(
            new Property(
                $name,
                $type
            )
        );
        return $this;
    }

    public function remove(int $id): void
    {
        $property = $this->collection->findFirst(function($key, Property $property) use($id){
            return $property->hasId($id);
        });
        if($property){
            $this->collection->removeElement($property);
        }
    }
}