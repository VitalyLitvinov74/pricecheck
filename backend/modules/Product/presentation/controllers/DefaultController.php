<?php

namespace app\modules\Product\presentation\controllers;

use app\controllers\BaseApiController;
use app\modules\Product\infrastructure\records\PropertyRecord;
use app\modules\Product\presentation\controllers\forms\ProductListSearchForm;
use Yii;

class DefaultController extends BaseApiController
{
    public function actionGeneralProperties(): array
    {
        return $this->jsonApi
            ->addBody(
                PropertyRecord::find()
                    ->asArray()
                    ->where(['product_template_id' => 1])
                    ->all()
            )
            ->asArray();
    }

    public function actionIndex()
    {
        $searchForm = new ProductListSearchForm();
        return $this->jsonApi
            ->setupCode(200)
            ->addBody(
                $searchForm
                    ->dataProvider(Yii::$app->request->get())
                    ->getModels()
            )
            ->asArray();
    }
}