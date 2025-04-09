<?php

namespace app\modules\ProductTableSettings\Presentation\Controllers;

use app\controllers\BaseApiController;
use app\modules\ProductTableSettings\Application\ActualizeProductListSettingsAction;
use app\modules\ProductTableSettings\Application\DisattachSettingAction;
use app\modules\ProductTableSettings\Application\UpsertSettingAction;
use app\forms\ColumnForm;
use app\forms\ProductListSearchForm;
use app\forms\ProductsTableSettingsForm;
use app\records\pg\ProductTemplateRecord;
use app\records\pg\PropertyRecord;
use Yii;

class IndexController extends BaseApiController
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

    public function actionIndex(): array
    {
        $searchForm = new ProductListSearchForm();
        $dataProvider = $searchForm->dataProvider(
            Yii::$app->request->get()
        );
        return $this->jsonApi
            ->addBody([
                'meta' => [
                    'page' => $dataProvider->getPagination()
                ],
                'data' => $dataProvider->getModels()
            ])
            ->asArray();
    }

    public function actionListSettings()
    {
        $settings = PropertyRecord::find()
            ->select([
                'id',
                'name',
                'relatedId' => 'id',
            ])
            ->where([
                'product_template_id' => ProductTemplateRecord::find()
                    ->select(['id'])
                    ->where(['id' => 1])
            ])
            ->with([
                'settings'
            ])
            ->asArray()
            ->all();
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

    public function acitionUpsertColumnSettings(): array
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