<?php

namespace app\forms;

use vloop\Yii2\Validators\ArrayValidator;
use vloop\Yii2\Validators\CustomEachValidator;

/**
 * @property ProductFieldForm[] $fields
 * @property ParsingMapForm[] $parsingMaps
 */
class ProductForm extends AbstractForm
{
    public $name;
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