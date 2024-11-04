<?php

namespace app\forms;

use app\libs\NestedForm;

class ProductListSettingsForm extends NestedForm
{

    public $settings;

    public function rules(): array
    {
        return [
            ['settings' => 'required'],
        ];
    }

    public function formName(): string
    {
        return '';
    }

    protected function nestedFormsMap(): array
    {
        return [
            'settings' => [
                'class' => PropertySettingForm::class,
                'scenario' => Scenarious::ChangeProductListSettings
            ]
        ];
    }
}