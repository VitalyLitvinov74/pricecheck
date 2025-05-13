<?php

namespace app\modules\Product\presentation\controllers\forms;

use app\records\elastic\ProductIndex;
use app\records\pg\ProductRecord;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\data\DataProviderInterface;

class ProductListSearchForm extends Model
{
    public $searchPhrase;

    public function rules(): array
    {
        return [
            ['searchPhrase', 'required'],
            ['searchPhrase', 'string'],
        ];
    }

    public function formName(): string
    {
        return '';
    }

    public function dataProvider(array $searchData): DataProviderInterface
    {
        $this->load($searchData);
        $query = ProductRecord::find()
            ->with([
                'productAttributes'
            ])
            ->orderBy(['id' => SORT_DESC]);
        if (!$this->validate()) {
            return new ArrayDataProvider(['models' => $query->asArray()->all()]);
        }
        $ids = ProductIndex::find()
            ->query([
                'match' => [
                    'attribute_value' => [
                        'query' => $this->searchPhrase
                    ]
                ],
            ])
            ->column('product_id');
        $query->andWhere(['id' => $ids])
            ->strictOrderBy('id', $ids);
        return new ArrayDataProvider([
            'models' => $query->asArray()->all(),
        ]);
    }
}