<?php

namespace app\presentation\forms;

use vloop\Yii2\Validators\ArrayValidator;
use vloop\Yii2\Validators\CustomEachValidator;
use yii\base\Model;

class ProductsTableSettingsForm extends Model
{
    public $settings;

    public function rules(): array
    {
        return [
            ['settings', 'required'],
            ['settings', CustomEachValidator::class, 'rule' => [
                ArrayValidator::class,
                'subRules' => ColumnSettingForm::subRules()
            ]]
        ];
    }

    public function formName(): string
    {
        return '';
    }
}