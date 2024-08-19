<?php

namespace app\domain\Product\Models;

use Doctrine\Common\Collections\ArrayCollection;

class Category
{
    private string $id;

    /**
     * @var ArrayCollection<int, Property>
     */
    private ArrayCollection $suportProperties;

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