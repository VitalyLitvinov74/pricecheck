<?php

namespace app\domain\ManageCategory;

use app\domain\ManageCategory\Models\CategoryField;
use app\libs\ObjectMapper\Attributes\HasManyModels;
use app\libs\ObjectMapper\Attributes\Property;
use Doctrine\Common\Collections\ArrayCollection;

class Category
{
    #[Property(
        mapWithArrayKey: 'name'
    )]
    private string $name;

    #[HasManyModels(
        nestedType: CategoryField::class,
        mapWithArrayKey: 'fields'
    )]
    private ArrayCollection $fields;

    public function __construct(string $name, ArrayCollection $fields = new ArrayCollection())
    {
        $this->fields = $fields;
        $this->name = $name;
    }

    public function addField(string $name, string $type): void
    {
        $this->fields->add(
            new CategoryField($name, $type)
        );
    }

    public function change(): void
    {
    }

    public function switchFieldInSearch(string $fieldName): void
    {
        $field = $this->fields->findFirst(
            function($key, CategoryField $field) use($fieldName){
                return $field->hasName($fieldName);
            }
        );
        if($field === null){
            return;
        }
        $field->switch();
    }
}