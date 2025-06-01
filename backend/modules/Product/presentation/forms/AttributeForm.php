<?php

namespace app\modules\Product\presentation\forms;


use app\forms\Scenarious;
use app\modules\Product\infrastructure\records\PropertyRecord;
use yii\base\Model;

class AttributeForm extends Model
{
    public $value;
    public $id;
    public $propertyId;

    public function rules(): array
    {
        return [
            [
                [
                    'value',
                    'property_id',
                    'id'
                ],
                'required',
                'skipOnEmpty' => false,
                'strict' => true,
                'skipOnError' => false
            ],
            [['id', 'propertyId'], 'integer'],
            ['propertyId', 'exist', 'targetClass' => PropertyRecord::class, 'targetAttribute' => 'id']
        ];
    }

    public function scenarios(): array
    {
        return [
            Scenarious::Default => ['value', 'propertyId', 'id'],
            Scenarious::CreateProduct => [
                'value', 'propertyId'
            ],
            Scenarious::UpdateProduct => [
                'id', 'value', 'property'
            ],
        ];
    }

    public function formName(): string
    {
        return '';
    }
}