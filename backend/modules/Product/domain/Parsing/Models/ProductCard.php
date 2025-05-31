<?php

namespace app\modules\Product\domain\Parsing\Models;

use Doctrine\Common\Collections\ArrayCollection;

class ProductCard
{
    /**
     * @param string $parsingVersion
     * @param ArrayCollection<int, CartAttribute> $attributes
     */
    public function __construct(
        private string $parsingVersion,
        private ArrayCollection $attributes = new ArrayCollection())
    {
    }

    public function addAttribute(string $propertyId, mixed $value): void
    {
        $this->attributes->add(
            new CartAttribute($propertyId, $value)
        );
    }
}