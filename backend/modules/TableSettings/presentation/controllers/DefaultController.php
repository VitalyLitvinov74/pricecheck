<?php

namespace app\modules\TableSettings\presentation\controllers;

use app\controllers\BaseApiController;
use app\forms\ProductsTableSettingsForm;
use app\modules\TableSettings\application\ActualizeProductListSettingsAction;
use app\modules\TableSettings\application\DisattachSettingAction;
use app\modules\TableSettings\application\UpsertSettingAction;
use app\modules\TableSettings\domain\Models\AdminPanelEntityType;
use app\modules\TableSettings\domain\Models\PropertyTypeOfBusinessLogicEntity;
use app\modules\TableSettings\presentation\forms\ColumnForm;
use app\modules\TableSettings\presentation\records\AdminPanelColumnsSettingsRecord;
use app\modules\TableSettings\presentation\records\AdminPanelEntitiesRecord;
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
                ->where(['type' => AdminPanelEntityType::Table])
                ->andWhere(['user_id' => 1]);

        if($propertyTypeOfBusinessLogicEntity === PropertyTypeOfBusinessLogicEntity::ProductProperty->value){
            $query = AdminPanelColumnsSettingsRecord::find()
                ->where(['admin_panel_entity_id' => $subQuery->select(['id'])])
                ->with(['productProperty']);
        }


        $settings = $query->asArray()->all();
        return $this->jsonApi->addBody($settings)->asArray();
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