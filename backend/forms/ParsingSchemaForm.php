<?php

namespace app\forms;

use app\domain\ManageCategory\Models\RelationshipPair;
use yii\base\Model;

class ParsingSchemaForm extends NestedForm
{
    public $name;
    /** @var RelationPairForm[] */
    public $map;
    public $categoryId;

    public $startWithRowNum;

    public function rules(): array
    {
        return [
            [['name', 'categoryId', 'map', 'startWithRowNum'], 'required'],
            [['name', 'categoryId'], 'string'],
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