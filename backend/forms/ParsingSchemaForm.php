<?php

namespace app\forms;

use app\domain\ManageProductType\Models\RelationshipPair;
use yii\base\Model;

class ParsingSchemaForm extends NestedForm
{
    public $name;
    /** @var RelationPairForm */
    public $map;
    public $productTypeId;

    public function rules(): array
    {
        return [
            [['name', 'productTypeId', 'map'], 'required'],
            ['name', 'string'],
            ['productTypeId', 'string']
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