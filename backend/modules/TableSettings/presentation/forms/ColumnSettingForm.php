<?php

namespace app\modules\TableSettings\presentation\forms;

use yii\base\Model;

class ColumnSettingForm extends Model
{
    public $propertyId;
    public $type;
    public $value;
    public $propertyTypeOfEntity;

    public function rules(): array
    {
        return self::subRules();
    }

    public static function subRules(): array
    {
        return [
            [['propertyId', 'value', 'type', 'propertyTypeOfEntity'], 'required'],
            [['type', 'propertyId', 'value', 'propertyTypeOfEntity'], 'integer'],
        ];
    }

    public function formName(): string
    {
        return '';
    }
}