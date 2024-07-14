<?php

namespace app\forms;

use app\domain\ManageCategories\Models\RelationshipPair;
use yii\base\Model;

class ParsingSchemaForm extends NestedForm
{
    public $name;
    /** @var RelationPairForm[] */
    public $map;
    public $productTypeId;

    public $startWithRowNum;

    public function rules(): array
    {
        return [
            [['name', 'productTypeId', 'map', 'startWithRowNum'], 'required'],
            [['name', 'productTypeId'], 'string'],
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