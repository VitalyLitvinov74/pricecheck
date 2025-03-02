<?php

namespace app\presentation\forms;

use app\infrastructure\libs\NestedForm;

class ParsingSchemaForm extends NestedForm
{
    public $id;

    public $name;

    /** @var RelationPairForm[] */
    public $map;

    public $startWithRowNum;

    public function rules(): array
    {
        return [
            [['name', 'map', 'startWithRowNum', 'id'], 'required'],
            [['name'], 'string'],
            [['startWithRowNum', 'id'], 'integer']
        ];
    }

    public function scenarios(): array
    {
        return [
            Scenarious::UpdateParsingSchema => ['id', 'name', 'map', 'startWithRowNum'],
            Scenarious::CreateParsingSchema => ['name', 'map', 'startWithRowNum']
        ];
    }

    public function formName(): string
    {
        return '';
    }

    protected function nestedFormsMap(): array
    {
        return [
            'map' => [
                'class' => RelationPairForm::class,
                'scenario' => $this->scenario
            ]
        ];
    }
}