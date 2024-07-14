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

    public function addProperty(string $name, mixed $value): void{
        $this->properties->add(
            new CardProperty($name, $value)
        );
    }
}