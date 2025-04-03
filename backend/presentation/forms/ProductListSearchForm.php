<?php

namespace app\presentation\forms;

use app\domain\ProductList\Models\SettingType;
use app\infrastructure\records\elastic\ProductIndex;
use app\infrastructure\records\pg\ProductsRecords;
use app\infrastructure\records\pg\AdminPanelProductListSettingsRecord;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\data\DataProviderInterface;
use yii\db\Query;

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
        $query = ProductsRecords::find()
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