<?php

namespace app\forms;

use yii\base\Model;

class ProductForm extends NestedForm
{
    /** @var ProductAttributeForm[] */
    public $productAttributes;

    public function rules(): array
    {
        return [
            [['productAttributes'], 'required'],
        ];
    }

    protected function nestedFormsMap(): array
    {
        return [
            'productAttributes' => [
                'class' => ProductAttributeForm::class,
                'scenario' => Scenarious::CreateProduct
            ]
        ];
    }
}