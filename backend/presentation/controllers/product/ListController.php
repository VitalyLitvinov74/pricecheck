<?php

namespace app\presentation\controllers\product;

use app\application\ProductListSettings\ActualizeProductListSettingsAction;
use app\application\ProductListSettings\AttachSettingAction;
use app\application\ProductListSettings\DisattachSettingAction;
use app\presentation\controllers\BaseApiController;
use app\presentation\forms\ColumnForm;
use app\presentation\forms\ProductListSearchForm;
use app\presentation\forms\ProductsTableSettingsForm;
use Yii;

class ListController extends BaseApiController
{
    private ActualizeProductListSettingsAction $actualizeProductListSettingsAction;
    private AttachSettingAction $attachSettingsAction;
    private DisattachSettingAction $disattachSettingAction;

    public function init(): void
    {
        parent::init();
        $this->actualizeProductListSettingsAction = new ActualizeProductListSettingsAction();
        $this->attachSettingsAction = new AttachSettingAction();
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

    public function updateColumnSettings(): array
    {
        $form = new ColumnForm();
        $form->load(Yii::$app->request->post());
        if ($form->validate()) {
            $this->attachSettingsAction->__invoke(
                1,
                $form->settingsDTOs()
            );
            return $this->jsonApi->setupCode(201)->asArray();
        }
        return $this->jsonApi->setupCode(422)->addModelErrors($form)->asArray();
    }
}