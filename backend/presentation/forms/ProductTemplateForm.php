<?php

namespace app\presentation\forms;

use app\application\ProductTemplate\DTOs\PropertyDTO;
use vloop\Yii2\Validators\ArrayValidator;
use vloop\Yii2\Validators\CustomEachValidator;
use yii\base\Model;

class ProductTemplateForm extends Model
{
    public $productTemplateId;
    public $actualProperties;

    public function rules(): array
    {
        return [
            [['productTemplateId', 'actualProperties'], 'required'],
            ['productTemplateId', 'integer'],
            ['actualProperties', CustomEachValidator::class, 'rule' => [
                ArrayValidator::class,
                'subRules' => ProductPropertyForm::staticRules()
            ]]
        ];
    }

    public function formName(): string
    {
        return '';
    }

    /**
     * @return PropertyDTO[]
     */
    public function propertiesDTOs(): array{
        $DTOs = [];
        foreach ($this->actualProperties as $property) {
            $DTOs[] = new PropertyDTO(
                $property['name'],
                $property['type'],
            );
        }
        return $DTOs;
    }
}