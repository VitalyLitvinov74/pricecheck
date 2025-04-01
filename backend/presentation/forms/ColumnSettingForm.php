<?php

namespace app\presentation\forms;

use yii\base\Model;

class ColumnSettingForm extends Model
{
    public $propertyId;
    public $type;
    public $value;

    public function rules(): array
    {
        return self::subRules();
    }

    public static function subRules(): array
    {
        return [
            [['propertyId', 'value', 'type'], 'required'],
            [['type', 'propertyId', 'value'], 'integer'],
        ];
    }

    public function formName(): string
    {
        return '';
    }
}