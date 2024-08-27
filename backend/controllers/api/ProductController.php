<?php

namespace app\controllers\api;

use app\domain\Product\UseCase\ProductsService;
use app\forms\CreateProductsViaDocument;
use app\forms\ProductForm;
use Throwable;
use Yii;
use yii\base\Exception;

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
        if ($form->validate()) {
            $this->service->createProduct($form->properties);
            return $this->jsonApi->setupCode(204)->asArray();
        }
        return $this->jsonApi->addModelErrors($form)->asArray();
    }

    public function actionBatchCreateViaDocument(): array
    {
        $form = new CreateProductsViaDocument();
        $form->load(Yii::$app->request->post(), '');
        if($form->validate()){
            $this->service->createByDocument($form->table, $form->parsingSchemaId);
            try {
                return $this->jsonApi->setupCode(204)->asArray();
            }catch (Throwable $throwable){
                return $this->jsonApi->addException($throwable)->asArray();
            }
        }
        return $this->jsonApi->addModelErrors($form)->asArray();
    }
}