<?php

namespace app\forms;

use yii\base\Model;

class ProductForm extends NestedForm
{
    /** @var ProductTypeForm[] */
    public $properties;
    public $categoryId;

    public function rules(): array
    {
        return [
            [['categoryId', 'properties'], 'required'],
            ['categoryId', 'string']
        ];
    }

    protected function nestedFormsMap(): array
    {
        return [
            'properties' => ProductTypeForm::class
        ];
    }
}