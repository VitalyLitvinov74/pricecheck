<?php

namespace app\forms;

use app\forms\PropertySettingForm;
use app\forms\Scenarious;
use app\libs\NestedForm;

class ProductListSettingsForm extends NestedForm
{
    public $settings;

    public function rules(): array
    {
        return [
            ['settings', 'required']
        ];
    }

    public function scenarios(): array
    {
        return [
            Scenarious::ChangeProductListSettings => ['settings']
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