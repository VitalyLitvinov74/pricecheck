<?php

namespace app\domain\ManageProductType;
use app\domain\ManageProductType\Models\ProductField;
use Doctrine\Common\Collections\ArrayCollection;

class ProductCard
{
    private string $name;
    private ArrayCollection $fields;
    private ArrayCollection $parsingMap;

    public function __construct(string $name, ArrayCollection $fields = new ArrayCollection())
    {
        $this->fields = $fields;
        $this->parsingMap = new ArrayCollection();
        $this->name = $name;
    }

    public function addParsingMap(){

    }

    public function addField(string $name, string $type): void
    {
        $this->fields->add(
            new ProductField($name, $type)
        );
    }
}