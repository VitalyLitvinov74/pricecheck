<?php

namespace app\forms;

use app\modules\TableSettings\Application\SettingDTO;
use yii\base\Model;

class ProductsTableSettingsForm extends Model
{
    public $userId;
    public $settings;
    private $settingsDTOs = [];

    public function rules(): array
    {
        return [
            [['settings'], 'required'],
            ['settings', 'default', 'value' => []],
            ['settings', 'validateSettings']
        ];
    }

    function validateSettings($attribute, $params)
    {
        foreach ($this->settings as $key => $setting) {
            $form = new ColumnSettingForm();
            $form->load($setting);
            if ($form->validate() === false) {
                $this->addError("settings[$key]", $form->getErrors());
                continue;
            }
            $this->settingsDTOs[] = new SettingDTO(
                $form->propertyId,
                $form->type,
                $form->value
            );
        }
    }

    /**
     * @return SettingDTO[]
     */
    public function settingsDTOs(): array
    {
        return $this->settingsDTOs;
    }

    public function formName(): string
    {
        return '';
    }
}