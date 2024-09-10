<?php

namespace app\forms;

use yii\base\Model;

class ParsingSchemaForm extends NestedForm
{
    public $name;
    /** @var RelationPairForm[] */
    public $map;

    public $startWithRowNum;

    public function rules(): array
    {
        return [
            [['name', 'map', 'startWithRowNum'], 'required'],
            [['name'], 'string'],
            ['startWithRowNum', 'integer']
        ];
    }

    public function formName(): string
    {
        return '';
    }

    protected function nestedFormsMap(): array
    {
        return [
            'map' => RelationPairForm::class
        ];
    }
}