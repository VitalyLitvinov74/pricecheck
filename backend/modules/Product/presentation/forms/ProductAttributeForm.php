<?php

namespace app\modules\Product\presentation\forms;


use app\forms\Scenarious;
use yii\base\Model;

class ProductAttributeForm extends Model
{
    public $value;
    public $id;
    /**
     * @var ProductPropertyForm
     */
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
            ]
        ];
    }

    public function scenarios(): array
    {
        return [
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

    public function propertyDTO():
    {

    }
}