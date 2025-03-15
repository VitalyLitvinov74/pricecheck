<?php

namespace app\presentation\forms;

use yii\base\Model;

class ColumnSettingForm extends Model
{
    public $propertyId;
    public $isEnabled;
    public $columnNum;

    public function rules(): array
    {
        return self::subRules();
    }

    public static function subRules(): array
    {
        return [
            [['propertyId', 'columnNum', 'isEnabled'], 'required'],
            ['isEnabled', 'boolean'],
            [['columnNum', 'propertyId'], 'integer']
        ];
    }

    public function formName(): string
    {
        return '';
    }
}