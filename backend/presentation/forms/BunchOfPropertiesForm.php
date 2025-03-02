<?php

namespace app\presentation\forms;

use yii\base\Model;

class BunchOfPropertiesForm extends Model
{
    public $productTypePropertyName;
    public $externalPropertyName;
    public $externalColumnNum;
    public $ignoreRowNums;

    public function rules(): array
    {
        return [
            ["productTypePropertyName", 'required'],
            ['productTypePropertyName', 'string'],
            [['externalPropertyName', 'externalColumnNum'], 'validateExternalFields'],
            [['externalColumnNum'], 'integer'],
            ['externalPropertyName', 'string'],
            ['ignoreRowNums', 'each', 'rule' => ['integer']]
        ];
    }

    public function validateExternalFields(): void
    {
        if ($this->externalPropertyName === null and $this->externalColumnNum === null) {
            $this->addError('externalPropertyName', 'Должна существовать хотябы одна ссылка на исходящее свойсво');
            $this->addError('externalColumnNum', 'Должна существовать хотябы одна ссылка на исходящее свойсво');
        }
    }

    public function formName(): string
    {
        return '';
    }
}