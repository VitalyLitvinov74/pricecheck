<?php

namespace app\forms;

class ProductForm extends NestedForm
{
    /** @var ProductAttributeForm[] */
    public $productAttributes;
    public $id;

    public function rules(): array
    {
        return [
            [['productAttributes', 'id'], 'required'],
            ['id', 'integer']
        ];
    }
    public function scenarios(): array
    {
        return [
            Scenarious::CreateProduct => ['productAttributes'],
            Scenarious::RemoveProduct => ['id']
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

    public function formName(): string
    {
        return '';
    }
}