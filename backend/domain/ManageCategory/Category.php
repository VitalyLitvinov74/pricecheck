<?php

namespace app\domain\ManageCategories;

use app\domain\ManageCategories\Models\CategoryField;
use app\domain\ManageCategories\Models\Schema;
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
     * @var ArrayCollection<int, Schema>
     */
    private ArrayCollection $parsingSchemas;

    public function __construct(string $name, ArrayCollection $fields = new ArrayCollection())
    {
        $this->fields = $fields;
        $this->parsingSchemas = new ArrayCollection();
        $this->name = $name;
    }

    /**
     * @param  Schema  $schema
     * @return void
     * @throws CategoryException
     */
    public function addParsingSchema(Schema $schema): void
    {
        foreach ($this->parsingSchemas as $existedSchema) {
            if ($existedSchema->compareWith($schema)) {
                throw new CategoryException(
                    'Уже существует карта соотношений с таким именем'
                );
            }
        }
        $this->parsingSchemas->add($schema);
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