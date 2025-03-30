<?php

namespace app\presentation\forms;

use app\domain\Property\Models\PropertySettingType;
use app\infrastructure\records\elastic\ProductIndex;
use app\infrastructure\records\pg\ProductsRecords;
use app\infrastructure\records\pg\PropertiesSettingsRecord;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\data\DataProviderInterface;
use yii\db\Query;

class ProductSearchForm extends Model
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
                'productAttributes' => function (Query $query) {
                    $query->where([
                        'property_id' => PropertiesSettingsRecord::find()
                            ->select(['property_id'])
                            ->where(['setting_type_id' => [
                                PropertySettingType::EnabledProductListCRM->value
                            ]])
                    ]);
                }
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