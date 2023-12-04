<?php

namespace app\forms;

use vloop\Yii2\Validators\ArrayValidator;
use vloop\Yii2\Validators\CustomEachValidator;

class ProductForm extends AbstractForm
{
    public $name;

    /**
     * @var ProductFieldForm[]
     */
    public $fields;

    public static function staticRules(): array
    {
        return [
            ['name', 'required'],
            [
                'fields',
                CustomEachValidator::class,
                'rule' => [
                    ArrayValidator::class,
                    'subRules' => ProductFieldForm::staticRules()
                ]
            ]
        ];
    }
}