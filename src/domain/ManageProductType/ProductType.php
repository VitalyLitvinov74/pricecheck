<?php

namespace app\domain\ProductMetadata;

use Doctrine\Common\Collections\ArrayCollection;

class ProductType
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