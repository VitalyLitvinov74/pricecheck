<?php

namespace app\presentation\forms;

use app\domain\Property\Models\PropertySettingType;
use app\infrastructure\records\elastic\ProductIndex;
use app\infrastructure\records\pg\ProductsRecords;
use app\infrastructure\records\pg\PropertiesSettingsRecord;
use Yii;
use yii\base\Model;
use yii\data\DataProviderInterface;
use yii\db\Query;
use yii\elasticsearch\ActiveDataProvider;

class ProductSearchForm extends Model
{
    public $searchPhrase;

    public function rules(): array
    {
        return [
            ['searchPhrase', 'required', 'string'],
        ];
    }

    public function formName(): string
    {
        return '';
    }

    public function dataProvider(): DataProviderInterface
    {
        $this->load(Yii::$app->request->get());
        $query = ProductsRecords::find()
            ->with([
                'productAttributes' => function (Query $query) {
                    $query->where([
                        'property_id' => PropertiesSettingsRecord::find()
                            ->select(['property_id'])
                            ->where(['setting_type_id' => [
                                PropertySettingType::OnInProductListCRM->value
                            ]])
                    ]);
                }
            ])
            ->orderBy(['id' => SORT_DESC]);
        if (!$this->validate()) {
            return new ActiveDataProvider();
        }
        $query->andWhere([
            'id' => ProductIndex::find()->search(), //тут настроить поиск в elastic
        ]);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}