<?php

namespace app\controllers\api;

use app\domain\Product\UseCase\ProductsService;
use app\forms\ProductForm;
use Yii;

class ProductController extends BaseApiController
{
    private ProductsService $service;
    public function init(): void
    {
        parent::init();
        $this->service = new ProductsService();
    }

    /**
     * @return string
     */
    public function actionCreate(): array
    {
        $form = new ProductForm();
        $form->load(Yii::$app->request->post(), '');
        if($form->validate()){
           $result = $this->service->createProduct($form->categoryId, $form->properties);
           return $this->jsonApi->setupCode(204)->asArray();
        }
        return $this->jsonApi->addModelErrors($form)->asArray();
    }
}