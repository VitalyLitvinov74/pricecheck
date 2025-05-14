<?php

namespace app\modules\Product\presentation\forms;


use app\forms\Scenarious;
use yii\base\Model;
use function PHPUnit\Framework\containsEqual;

class ProductAttributeForm extends Model
{
    public $value;
    public $id;
    /**
     * @var ProductPropertyForm
     */
    public $propertyForm;
    public $property;

    public function rules(): array
    {
        return [
            [
                [
                    'value',
                    'property',
                    'id'
                ],
                'required',
                'skipOnEmpty' => false,
                'strict' => true,
                'skipOnError' => false
            ],
            ['property', 'validateProperty']
        ];
    }

    public function scenarios(): array
    {
        return [
            Scenarious::Default => ['value', 'property', 'id'],
            Scenarious::CreateProduct => [
                'value', 'property'
            ],
            Scenarious::UpdateProduct => [
                'id', 'value', 'property'
            ]
        ];
    }

    public function formName(): string
    {
        return '';
    }

    public function validateProperty()
    {
        $form = new ProductPropertyForm([
            'scenario' => $this->scenario
        ]);
        $form->load($this->property);
        if(!$form->validate()){
            $this->addError('property', $form->getErrors());
            return;
        }
        $this->propertyForm = $form;
    }
}