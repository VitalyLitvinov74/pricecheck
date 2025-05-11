<?php

namespace app\modules\UserSettings\presentation\forms;

use app\modules\UserSettings\application\SettingDTO;
use yii\base\Model;

class SettingForm extends Model
{
    public $id;
    public $stringValue;
    public $intValue;
    public $type;
    public $entityId;
    public $entityType;

    public function rules(): array
    {
        return [
            [
                ['stringValue', 'intValue'],
                'required',
                'skipOnEmpty' => false,
                'isEmpty' => function ($value) {
                    return is_null($value); // Считаем пустым только null
                }
            ],
            [[ 'type', 'entityId', 'entityType'], 'required'],
            [['intValue', 'type', 'entityId', 'entityType', 'id'], 'integer'],
//            ['stringValue', 'string'],
        ];
    }

    public function formName(): string
    {
        return '';
    }

    public function settingDTO(): SettingDTO
    {
        return new SettingDTO(
            $this->id,
            $this->type,
            $this->intValue,
            $this->stringValue,
            $this->entityType,
            $this->entityId,
        );
    }
}