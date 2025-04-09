<?php

namespace app\controllers\product;

use app\controllers\BaseApiController;
use app\modules\ProductTable\Application\ActualizeProductListSettingsAction;
use app\modules\ProductTable\Application\DisattachSettingAction;
use app\modules\ProductTable\Application\UpsertSettingAction;
use app\forms\ColumnForm;
use app\forms\ProductListSearchForm;
use app\forms\ProductsTableSettingsForm;
use Yii;

class ListController extends BaseApiController
{
    private ActualizeProductListSettingsAction $actualizeProductListSettingsAction;
    private UpsertSettingAction $upsertSettingsAction;
    private DisattachSettingAction $disattachSettingAction;

    public function init(): void
    {
        parent::init();
        $this->actualizeProductListSettingsAction = new ActualizeProductListSettingsAction();
        $this->upsertSettingsAction = new UpsertSettingAction();
        $this->disattachSettingAction = new DisattachSettingAction();
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