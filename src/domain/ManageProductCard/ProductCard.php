<?php

namespace app\domain\ManageProductCard;
use app\domain\ManageProductCard\Models\CardField;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\Property;
use Doctrine\Common\Collections\ArrayCollection;

class ProductCard
{
    #[Property(
        mapWithArrayKey: 'name'
    )]
    private string $name;

    #[HasManyModels(
        nestedType: CardField::class,
        mapWithArrayKey: 'fields'
    )]
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
            new CardField($name, $type)
        );
    }
}