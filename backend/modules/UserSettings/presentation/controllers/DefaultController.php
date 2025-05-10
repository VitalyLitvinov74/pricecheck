<?php

namespace app\modules\UserSettings\presentation\controllers;

use app\controllers\BaseApiController;
use app\forms\ProductsTableSettingsForm;
use app\modules\UserSettings\application\ActualizeProductListSettingsAction;
use app\modules\UserSettings\application\DisattachSettingAction;
use app\modules\UserSettings\application\UpsertSettingAction;
use app\modules\UserSettings\domain\Models\EntityType;
use app\modules\UserSettings\domain\Models\SettingType;
use app\modules\UserSettings\infrastructure\records\UserSettingsRecord;
use app\modules\UserSettings\presentation\forms\ColumnForm;
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
        $settings = UserSettingsRecord::find()
            ->where(['user_id' => 1])
            ->asArray()
            ->all();

        $defaultSettingsForMerge = [];

        foreach ($this->defaultSettings() as $defaultSetting) {
            $settingIsUse = false;
            foreach ($settings as $setting) {
                if ($defaultSetting['type'] == $setting['type']) {
                    $settingIsUse = true;
                    break;
                }
            }
            if (!$settingIsUse) {
                $defaultSettingsForMerge[] = $defaultSetting;
            }
        }

        $settings = array_merge($settings, $defaultSettingsForMerge);

        return $this->jsonApi
            ->addBody($settings)
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

    public function actionDefaultSettings()
    {
        return $this->jsonApi
            ->addBody([
                'data' => $this->defaultSettings()
            ])
            ->asArray();
    }

    private function defaultSettings()
    {
        return [
            [
                'user_id' => Yii::$app->user->id,
                'type' => SettingType::IsEnabled->value,
                'string_value' => '',
                'int_value' => 1,
                'entity_id' => 0,
                'entity_type' => EntityType::ProductProperty->value
            ],
            [
                'user_id' => Yii::$app->user->id,
                'type' => SettingType::ColumnNumber->value,
                'string_value' => '',
                'int_value' => 99,
                'entity_id' => 0,
                'entity_type' => EntityType::ProductProperty->value
            ],
        ];
    }
}