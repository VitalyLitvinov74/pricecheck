<?php

namespace app\modules\UserSettings\presentation\forms;

use app\modules\UserSettings\application\SettingDTO;
use yii\base\Model;

class UserSettingsForm extends Model
{
    public $settings;
    public $DTOs;

    public function rules(): array
    {
        return [
            ['settings', 'validateSettings']
        ];
    }

    public function formName(): string
    {
        return '';
    }

    public function validateSettings(): void
    {
        foreach ($this->settings as $key => $setting) {
            $form = new SettingForm();
            $form->load($setting);
            if (!$form->validate()) {
                $this->addError("settings[$key]", $form->getErrors());
                continue;
            }
            $this->DTOs[] = $form->settingDTO();
        }
    }

    /**
     * @return SettingDTO[]
     */
    public function settingsDTOs(): array
    {
        return $this->DTOs;
    }
}