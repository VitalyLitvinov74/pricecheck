<?php

namespace app\domain\ParseDocument\Models;

use Doctrine\Common\Collections\ArrayCollection;

class ProductCard
{
    /**
     * @param  string  $categoryId
     * @param  ArrayCollection<int, CardProperty>  $properties
     */
    public function __construct(
        private string $categoryId,
        private ArrayCollection $properties = new ArrayCollection()) { }

    public function add(CardProperty $property): void{
        $this->properties->add($property);
    }
}