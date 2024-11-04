<?php

namespace app\forms;

use app\domain\Property\Models\PropertySettingType;
use app\libs\NestedForm;

class PropertySettingForm extends NestedForm
{
    public $settingTypeId;
    /** @var ProductPropertyForm */
    public $property;

    public function rules(): array
    {
        return [
            [['settingTypeId', 'property'], 'required'],
            ['settingTypeId', 'in', 'range' => [
                PropertySettingType::OnInProductListCRM->value,
                PropertySettingType::OffInProductListCRM->value
            ]]
        ];
    }

    public function formName(): string
    {
        return '';
    }

    public function scenarios(): array
    {
        return [
            Scenarious::ChangeProductListSettings => ['settingTypeId', 'property']
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