<?php

namespace app\presentation\forms;

use app\infrastructure\libs\NestedForm;

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
            Scenarious::RemoveProduct => ['id'],
            Scenarious::UpdateProduct => ['id', 'productAttributes']
        ];
    }

    protected function nestedFormsMap(): array
    {
        return [
            'productAttributes' => [
                'class' => ProductAttributeForm::class,
                'scenario' => $this->scenario
            ]
        ];
    }

    public function formName(): string
    {
        return '';
    }
}