<?php

namespace app\modules\Product\domain;

use app\modules\Product\domain\Models\Attribute;
use Doctrine\Common\Collections\ArrayCollection;

class Product
{
    /** @var ArrayCollection<int, Attribute> $attributes */
    private ArrayCollection $attributes;

    public function __construct(
        private int|null $id = null
    )
    {
        $this->attributes = new ArrayCollection();
    }

    /**
     * @param Attribute[] $attributes
     * @return void
     */
    public function fill(array $attributes): void
    {

    }

    public function attachWith(Attribute $attribute): void
    {
        $existedSameAttribute = $this->attributes->findFirst(
            function ($key, Attribute $existedAttribute) use ($attribute) {
                return $attribute->compareWith($existedAttribute);
            }
        );
        if ($existedSameAttribute !== null) {

            $this->attributes->removeElement($existedSameAttribute);
            $this->attributes->add($attribute);
            return;
        }
        $this->attributes->add($attribute);
    }

    public function has(Attribute $attribute): bool
    {
        return $this->attributes->exists(
            function ($key, Attribute $existedAttribute) use ($attribute) {
                return $existedAttribute->compareWith($attribute);
            }
        );
    }
}