<?php

namespace app\domain\Product;

use app\domain\Product\Models\Category;
use app\domain\Product\Models\Property;
use Doctrine\Common\Collections\ArrayCollection;

class Product
{
    private string|null $id = null; //автоинкримент
    private ArrayCollection $properties;
    public function __construct(private Category $category)
    {
    }

    public function add(Property $property): void{
        if($this->category->notSupportProperty($property)){
            return;
        }
        if($this->has($property)){
            return;
        }
        $this->properties->add($property);
    }

    public function has(Property $property): bool
    {
        return $this->properties->exists(
            function($key, Property $existedProperty) use ($property){
                return $existedProperty->hasSameName($property);
            }
        );
    }
}