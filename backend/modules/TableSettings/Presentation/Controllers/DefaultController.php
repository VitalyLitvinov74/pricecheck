<?php

namespace app\modules\TableSettings\Presentation\Controllers;

use app\controllers\BaseApiController;
use app\forms\ProductListSearchForm;
use app\forms\ProductsTableSettingsForm;
use app\modules\TableSettings\Application\ActualizeProductListSettingsAction;
use app\modules\TableSettings\Application\DisattachSettingAction;
use app\modules\TableSettings\Application\UpsertSettingAction;
use app\modules\TableSettings\Presentation\Forms\ColumnForm;
use app\records\pg\ProductTemplateRecord;
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