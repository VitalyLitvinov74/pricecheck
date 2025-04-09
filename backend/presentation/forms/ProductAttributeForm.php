<?php

namespace app\presentation\forms;

use app\libs\NestedForm;

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
            [['value', 'property', 'id'], 'required', 'skipOnEmpty' => false, 'strict' => true, 'skipOnError' => false]
        ];
    }

    public function scenarios(): array
    {
        return [
            Scenarious::CreateProduct => [
                'value', 'property'
            ],
            Scenarious::UpdateProduct => [
                'id', 'value', 'property'
            ]
        ];
    }

    protected function nestedFormsMap(): array
    {
        return [
            'property' => [
                'class' => ProductPropertyForm::class,
                'scenario' => $this->scenario
            ]
        ];
    }

    public function formName(): string
    {
        return '';
    }
}