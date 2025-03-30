<?php

namespace app\presentation\controllers\product;

use app\presentation\controllers\BaseApiController;
use app\presentation\forms\ProductSearchForm;
use Yii;

class ListController extends BaseApiController
{
    public function actionUpdate()
    {

    }

    public function actionIndex(): array
    {
        $searchForm = new ProductSearchForm();
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

    }
}