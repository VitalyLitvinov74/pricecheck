<?php

namespace app\modules\Product\domain\ParceDocument\Models;

use Doctrine\Common\Collections\ArrayCollection;

class ProductCard
{
    /**
     * @param string $parsingVersion
     * @param ArrayCollection<int, CardProperty> $properties
     */
    public function __construct(
        private string $parsingVersion,
        private ArrayCollection $properties = new ArrayCollection())
    {
    }

    public function addProperty(string $id, mixed $value): void
    {
        $this->properties->add(
            new CardProperty($id, $value)
        );
    }
}