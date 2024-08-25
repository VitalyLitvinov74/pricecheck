<?php

namespace app\forms;

use yii\base\Model;

class ProductForm extends NestedForm
{
    /** @var ProductPropertyForm[] */
    public $properties;

    public function rules(): array
    {
        return [
            [['properties'], 'required'],
            ['string']
        ];
    }

    protected function nestedFormsMap(): array
    {
        return [
            'properties' => [
                'class' => ProductPropertyForm::class,
                'scenario' => 'create-product'
            ]
        ];
    }
}