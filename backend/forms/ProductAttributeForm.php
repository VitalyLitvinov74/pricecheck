<?php

namespace app\forms;

class ProductAttributeForm extends NestedForm
{
    public $value;
    public $id;
    /**
     * @var ProductPropertyForm
     */
    public $property;

    public function rules(): array
    {
        return [
            [['value', 'property'], 'required', 'skipOnEmpty' => false, 'strict' => true, 'skipOnError' => false]
        ];
    }

    public function scenarios(): array
    {
        return [
            Scenarious::CreateProduct => [
                'value', 'property'
            ],
        ];
    }

    protected function nestedFormsMap(): array
    {
        return [
            'property' => [
                'class' => ProductPropertyForm::class,
                'scenario' => Scenarious::CreateProduct
            ]
        ];
    }

    public function formName(): string
    {
        return '';
    }
}