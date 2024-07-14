<?php

namespace app\domain\ManageProductType;

use app\domain\ManageProductType\Models\CategoryField;
use app\domain\ManageProductType\Models\ParsingMap;
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
    /**
     * @var ArrayCollection<int, ParsingMap>
     */
    private ArrayCollection $parsingMaps;

    public function __construct(string $name, ArrayCollection $fields = new ArrayCollection())
    {
        $this->fields = $fields;
        $this->parsingMaps = new ArrayCollection();
        $this->name = $name;
    }

    /**
     * @param  string  $name
     * @param  ParsingMap  $map
     * @return void
     * @throws CategoryException
     */
    public function addParsingMap(string $name, ParsingMap $map): void
    {
        foreach ($this->parsingMaps as $map) {
            if ($map->hasName($name)) {
                throw new CategoryException(
                    'Уже существует карта соотношений с таким именем'
                );
            }
        }
        $this->parsingMaps->add($map);
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