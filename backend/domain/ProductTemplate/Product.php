<?php

namespace app\domain\ProductTemplate;

use app\domain\ProductTemplate\Models\Property;
use app\domain\ProductTemplate\Models\PropertyId;
use app\domain\ProductTemplate\Models\ValueType;
use Doctrine\Common\Collections\ArrayCollection;

class Product
{
    private int $id;

    /**
     * @param ArrayCollection<int, Property> $properties
     */
    public function __construct(private ArrayCollection $properties = new ArrayCollection([]))
    {

    }

    public function add(Property $property): void
    {
        foreach ($this->properties as $propertyItem) {
            if ($propertyItem->equalsTo($property)) {
                return;
            }
        }
        $this->properties->add($property);
    }

    public function removeProperty(string $propertyName): void
    {
        foreach ($this->properties as $propertyItem) {
            if ($propertyItem->hasName($propertyName)) {
                $this->properties->removeElement($propertyItem);
                return;
            }
        }
    }

    /**
     * @param string $oldName
     * @param string $newName
     * @param ValueType $type
     * @return void
     * @throws \Exception
     */
    public function changeProperty(string $oldName, string $newName, ValueType $type): void
    {
        $propertyForChange = null;
        foreach ($this->properties as $propertyItem) {
            if ($propertyItem->hasName($oldName)) {
                $propertyForChange = $propertyItem;
            }
            if ($propertyItem->hasName($newName)) {
                throw new \Exception(
                    'Невозможно изменить имя, т.к. существует свойство с таким же именем'
                );
            }
        }
        $propertyForChange->rename($newName);
        $propertyForChange->change($type);
    }
}