<?php

namespace app\controllers\api;

use app\forms\ProductTypeForm;
use yii\filters\VerbFilter;

class ProductController extends BaseApiController
{
    public function behaviors(): array
    {
        return [
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'product-type' => ['post'],
                ],
            ]
        ];
    }

    public function actionProductType(): array
    {
        $productTypeForm = new ProductTypeForm();
        $productTypeForm->load($this->request->post());
        if ($productTypeForm->validate()) {
            return ['hello'];
        }
        return $this->jsonApi->addModelErrors($productTypeForm)->asArray();
    }
}