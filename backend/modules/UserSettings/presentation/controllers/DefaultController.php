<?php

namespace app\modules\UserSettings\presentation\controllers;

use app\controllers\BaseApiController;
use app\forms\ProductsTableSettingsForm;
use app\modules\UserSettings\application\ActualizeProductListSettingsAction;
use app\modules\UserSettings\application\DisattachSettingAction;
use app\modules\UserSettings\application\UpsertSettingAction;
use app\modules\UserSettings\domain\Models\ColumnOf;
use app\modules\UserSettings\domain\Models\EntityType;
use app\modules\UserSettings\domain\Models\SettingType;
use app\modules\UserSettings\infrastructure\records\ProductPropertyRecord;
use app\modules\UserSettings\infrastructure\records\UserSettingsRecord;
use app\modules\UserSettings\presentation\forms\ColumnForm;
use app\records\pg\PropertyRecord;
use Yii;

class DefaultController extends BaseApiController
{
    private ActualizeProductListSettingsAction $actualizeProductListSettingsAction;
    private UpsertSettingAction $upsertSettingsAction;
    private DisattachSettingAction $disAttachSettingAction;

    public function init(): void
    {
        parent::init();
        $this->actualizeProductListSettingsAction = new ActualizeProductListSettingsAction();
        $this->upsertSettingsAction = new UpsertSettingAction();
        $this->disAttachSettingAction = new DisattachSettingAction();
    }

    public function actionUpdate()
    {

    }

//    public function actionIndex(): array
//    {
//        $searchForm = new ProductListSearchForm();
//        $dataProvider = $searchForm->dataProvider(
//            Yii::$app->request->get()
//        );
//        return $this->jsonApi
//            ->addBody([
//                'meta' => [
//                    'page' => $dataProvider->getPagination()
//                ],
//                'data' => $dataProvider->getModels()
//            ])
//            ->asArray();
//    }

    public function actionIndex(int $propertyTypeOfBusinessLogicEntity): array
    {
        $subQuery =
            AdminPanelEntitiesRecord::find()
                ->where(['type' => EntityType::Table])
                ->andWhere(['user_id' => 1]);

        if ($propertyTypeOfBusinessLogicEntity === ColumnOf::Product->value) {
            $query = AdminPanelColumnsSettingsRecord::find()
                ->where(['admin_panel_entity_id' => $subQuery->select(['id'])]);
        }


        $settings = $query->asArray()->all();
        return $this->jsonApi->addBody($settings)->asArray();
    }

    public function actionColumnsList(int $columnsForEntities): array
    {
        $query = match ($columnsForEntities) {
            ColumnOf::Product->value => PropertyRecord::find()
                ->where(['product_template_id' => 1])
                ->with(['tableSettings'])
        };
        $columnsList = $query->asArray()->all();
        return $this->jsonApi->addBody($columnsList)->setupCode(200)->asArray();

    }

    public function actionForProductsTable(): array
    {
        $properties = ProductPropertyRecord::find()
            ->select([
                'id',
                'name'
            ])
            ->with([
                'userSettings' => function () {
                    return UserSettingsRecord::find()
                        ->where(['user_id' => 1]);
                }
            ])
            ->asArray()
            ->all();
        return $this->jsonApi
            ->addBody($properties)
            ->asArray();
    }

    public function actionDefaultSettings(): array
    {
        return $this->jsonApi
            ->addBody([
                [
                    'type' => SettingType::IsEnabled->value,
                    'value' => 1,
                    'entity_type' => EntityType::ProductProperty->value
                ],
                [
                    'type' => SettingType::ColumnNumber->value,
                    'value' => 1,
                    'entity_type' => EntityType::ProductProperty->value
                ]
            ])->asArray();
    }

    public function actionUpdateView(): array
    {
        $form = new ProductsTableSettingsForm();
        $form->load(Yii::$app->request->post());
        if ($form->validate()) {
            $this->actualizeProductListSettingsAction->__invoke(
                1,
                $form->settingsDTOs()
            );
            return $this->jsonApi->setupCode(204)->asArray();
        }
        return $this->jsonApi->addModelErrors($form)->asArray();
    }

    public function actionUpsertColumnSettings(): array
    {
        $form = new ColumnForm();
        $form->load(Yii::$app->request->post());
        if ($form->validate()) {
            $this->upsertSettingsAction->__invoke(
                1,
                $form->settingsDTOs()
            );
            return $this->jsonApi->setupCode(201)->asArray();
        }
        return $this->jsonApi->setupCode(422)->addModelErrors($form)->asArray();
    }
}