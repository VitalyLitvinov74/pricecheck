<?php

namespace app\infrastructure\records\elastic;

use yii\elasticsearch\ActiveRecord;

/**
 * @property int property_id
 * @property int product_id
 * @property string $attribute_value
 */
class ProductIndex extends ActiveRecord
{
    public static function index(): string
    {
        return 'products';
    }

    public function attributes(): array
    {
        return [
            'property_id',
            'product_id',
            'attribute_value',
        ];
    }
}