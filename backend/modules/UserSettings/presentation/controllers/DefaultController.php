<?php

namespace app\modules\UserSettings\presentation\controllers;

use app\controllers\BaseApiController;
use app\forms\ProductsTableSettingsForm;
use app\modules\UserSettings\application\ActualizeProductListSettingsAction;
use app\modules\UserSettings\application\DisattachSettingAction;
use app\modules\UserSettings\application\UpsertSettingAction;
use app\modules\UserSettings\application\SettingsService;
use app\modules\UserSettings\domain\Models\EntityType;
use app\modules\UserSettings\domain\Models\SettingType;
use app\modules\UserSettings\domain\User;
use app\modules\UserSettings\infrastructure\records\UserSettingsRecord;
use app\modules\UserSettings\presentation\forms\UserSettingsForm;
use Throwable;
use Yii;

class DefaultController extends BaseApiController
{
    private SettingsService $settingsService;

    public function init(): void
    {
        parent::init();
        $this->settingsService = new SettingsService();
    }

    public function actionUpdate()
    {

    }

    public function actionIndex(): array
    {
        $settings = UserSettingsRecord::find()
            ->select([
                'entityId' => 'entity_id',
                'entityType' => 'entity_type',
                'type',
                'id',
                'intValue' => 'int_value',
                'stringValue' => 'string_value',
                'userId' => 'user_id'
            ])
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

    public function actionUpsert(): array
    {
        $form = new UserSettingsForm();
        $form->load(Yii::$app->request->post());
        if ($form->validate()) {
            try {
                $this->settingsService->upsertUserSettings(
                    1,
                    $form->settingsDTOs()
                );
                return $this->jsonApi
                    ->setupCode(201)
                    ->asArray();
            }catch (Throwable $exception){
                return $this->jsonApi
                    ->setupCode(500)
                    ->addException($exception)
                    ->asArray();
            }
        }
        return $this->jsonApi
            ->setupCode(422)
            ->addModelErrors($form)
            ->asArray();
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
                'userId' => Yii::$app->user->id,
                'type' => SettingType::IsEnabled->value,
                'stringValue' => '',
                'intValue' => 1,
                'entityId' => null,
                'entityType' => EntityType::ProductProperty->value
            ],
            [
                'userId' => Yii::$app->user->id,
                'type' => SettingType::ColumnNumber->value,
                'stringValue' => '',
                'intValue' => 99,
                'entityId' => null,
                'entityType' => EntityType::ProductProperty->value
            ],
        ];
    }
}