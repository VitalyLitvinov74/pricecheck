<?php

namespace app\domain\ProductProperty;

use app\domain\ProductProperty\Models\Property;
use app\domain\ProductProperty\Models\Type;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use Doctrine\Common\Collections\ArrayCollection;
use yii\base\Exception;

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
//            throw new Exception(
//                sprintf('Свойство товара %s, уже существует', $name),
//                422
//            );
        }
        $this->collection->add(
            new Property(
                $name,
                $type
            )
        );
        return $this;
    }
}