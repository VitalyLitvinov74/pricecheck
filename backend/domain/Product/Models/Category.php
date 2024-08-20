<?php

namespace app\domain\Product\Models;

use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use Doctrine\Common\Collections\ArrayCollection;
#[DomainModel]
class Category
{
    private string $id;

    /**
     * @var ArrayCollection<int, Property>
     */
    #[HasManyModels(Property::class, defaultMapWith: 'fields')]
    private ArrayCollection $supportProperties;

    private function __construct()
    {
        //нельзя создать в текущем контексте
    }

    public function notSupportProperty(Property $property): bool{
        return $this->suportProperties->exists(
            function($key, Property $supportProperty) use ($property){
                return $property->hasSameName($supportProperty);
            }
        );
    }
}