<?php

namespace app\modules\Product\presentation\controllers;

use app\controllers\BaseApiController;
use app\modules\Product\infrastructure\records\ProductPropertyRecord;
use app\modules\UserSettings\domain\Models\SettingType;
use Yii;

class DefaultController extends BaseApiController
{
    public function actionAvailableProperties(): array
    {
        return $this->jsonApi
            ->addBody(
                ProductPropertyRecord::find()
                    ->asArray()
                    ->all()
            )
            ->asArray();
    }
}