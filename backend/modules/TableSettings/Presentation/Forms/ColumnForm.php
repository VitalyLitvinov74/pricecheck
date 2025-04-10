<?php

namespace app\modules\TableSettings\Presentation\Forms;

use app\forms\ColumnSettingForm;
use app\modules\TableSettings\application\SettingDTO;
use yii\base\Model;

class ColumnForm extends Model
{
    public $relatedId;
    public $settings;
    private $DTOs;

    public function rules(): array
    {
        return [
            ['relatedId', 'required'],
            ['relatedId', 'integer'],
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
            $form = new ColumnSettingForm();
            $form->load($setting);
            if (!$form->validate()) {
                $this->addError("settings[$key]", $form->getErrors());
                continue;
            }
            $this->DTOs[] = new SettingDTO(
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
        return $this->DTOs;
    }
}