<?php

namespace app\controllers;

use app\collections\ProductPropertyCollection;
use app\domain\ParsingSchema\UseCases\ParsingSchemaService;
use app\domain\Product\UseCase\ProductsService;
use app\forms\CreateProductsViaDocumentForm;
use app\forms\ProductForm;
use app\records\ProductPropertiesRecord;
use Throwable;
use Yii;

class ProductController extends BaseApiController
{
    private ProductsService $service;
    private ParsingSchemaService $parsingSchemaService;

    public function init(): void
    {
        parent::init();
        $this->service = new ProductsService();
        $this->parsingSchemaService = new ParsingSchemaService();
    }

    /**
     * @return string
     */
    public function actionCreate(): array
    {
        $form = new ProductForm();
        $form->load(Yii::$app->request->post(), '');
        if ($form->validate()) {
            $this->service->createProduct($form->productAttributes);
            return $this->jsonApi->setupCode(204)->asArray();
        }
        return $this->jsonApi->addModelErrors($form)->asArray();
    }

    public function actionBatchCreateViaDocument(): array
    {
        $form = new CreateProductsViaDocumentForm();
        $form->load(Yii::$app->request->post(), '');
        if ($form->validate()) {
            $this->service->createByDocument($form->table, $form->parsingSchemaId);
            try {
                return $this->jsonApi->setupCode(204)->asArray();
            } catch (Throwable $throwable) {
                return $this->jsonApi->addException($throwable)->asArray();
            }
        }
        return $this->jsonApi->addModelErrors($form)->asArray();
    }

    public function actionAllPropertiesList(): array
    {
        return $this->jsonApi
            ->setupCode(200)
            ->addBody(
                ProductPropertiesRecord::find()
                    ->select([
                        'id',
                        'name'
                    ])
                    ->asArray()->all()
            )
            ->asArray();
    }
}