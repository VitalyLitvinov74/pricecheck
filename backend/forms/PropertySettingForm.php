<?php

namespace app\forms;

use app\domain\Product\SubDomains\Property\Models\PropertySettingType;
use app\forms\ProductPropertyForm;
use app\forms\Scenarious;
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
                PropertySettingType::EnabledProductListCRM->value,
                PropertySettingType::DisabledInProductListCRM->value
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
            Scenarious::ChangeProductListSettings => ['settingTypeId', 'property'],
            Scenarious::DisAttachSetting => ['settingTypeId', 'property'],
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
}