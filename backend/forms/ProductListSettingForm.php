<?php

namespace app\forms;

use app\libs\NestedForm;

class ProductListSettingForm extends NestedForm
{
    public $settingTypeId;
    public $property;

    public function rules(): array
    {
        return [
            [['settingTypeId', 'property'], 'required'],
            ['settingTypeId', 'in', 'range' => []]
        ];
    }

    protected function nestedFormsMap(): array
    {
        return [
            'property' => [
                'class' => ProductPropertyForm::class,
                'scenario' => Scenarious::ChangeProductListSettings
            ]
        ];
    }
}