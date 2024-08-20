<?php

namespace app\domain\Product;

use app\domain\Product\Models\Category;
use app\domain\Product\Models\Property;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\HasOneModel;
use Doctrine\Common\Collections\ArrayCollection;

#[DomainModel]
class Product
{
    #[\app\libs\ObjectMapper\Attributes\Property(defaultMapWith: 'id')]
    private string|null $id = null; //автоинкримент

    #[HasManyModels(
        nestedType: Property::class,
        defaultMapWith: 'properties'
    )]
    private ArrayCollection $properties;

    public function __construct(
        #[HasOneModel(
            nestedType: Category::class,
            defaultMapWith: 'category'
        )]
        private Category $category
    )
    {
    }

    public function add(Property $property): void
    {
        if ($this->category->notSupportProperty($property)) {
            return;
        }
        if ($this->has($property)) {
            return;
        }
        $this->properties->add($property);
    }

    public function has(Property $property): bool
    {
        return $this->properties->exists(
            function ($key, Property $existedProperty) use ($property) {
                return $existedProperty->hasSameName($property);
            }
        );
    }
}