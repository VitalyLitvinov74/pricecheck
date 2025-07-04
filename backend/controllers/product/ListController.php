<?php

namespace app\controllers\product;

use app\controllers\BaseApiController;
use app\modules\Product\presentation\forms\ProductListSearchForm;
use app\modules\UserSettings\application\ActualizeProductListSettingsAction;
use app\modules\UserSettings\application\DisattachSettingAction;
use app\modules\UserSettings\application\UpsertSettingAction;
use app\modules\UserSettings\Presentation\Forms\UserSettingsForm;
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

    public function acitionUpsertColumnSettings(): array
    {
        $form = new UserSettingsForm();
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