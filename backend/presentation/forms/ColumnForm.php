<?php

namespace app\presentation\forms;

use yii\base\Model;

class ColumnForm extends Model
{
    public $relatedId;
    public $name;
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
            $form->propertyId = $this->relatedId;
            if (!$form->validate()) {
                $this->addError("settings[$key]", $form->getErrors());
                continue;
            }
            $this->DTOs[] = '';
        }
    }
}