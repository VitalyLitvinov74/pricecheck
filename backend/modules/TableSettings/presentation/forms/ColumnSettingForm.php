<?php

namespace app\modules\TableSettings\presentation\forms;

use yii\base\Model;

class ColumnSettingForm extends Model
{
    public $propertyId;
    public $type;
    public $value;
    public $entityType;

    public function rules(): array
    {
        return self::subRules();
    }

    public static function subRules(): array
    {
        return [
            [['propertyId', 'value', 'type', 'entityType'], 'required'],
            [['type', 'propertyId', 'value', 'entityType'], 'integer'],
        ];
    }

    public function formName(): string
    {
        return '';
    }
}