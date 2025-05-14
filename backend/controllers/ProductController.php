<?php

namespace app\controllers;

use app\domain\Product\SubDomains\Property\Models\PropertySettingType;
use app\domain\Product\UseCase\ProductsService;
use app\forms\CreateProductsViaDocumentForm;
use app\forms\Scenarious;
use app\modules\Product\presentation\forms\ProductForm;
use Throwable;
use Yii;

class ProductController extends BaseApiController
{
    private ProductsService $service;

    public function init(): void
    {
        parent::init();
        $this->service = new ProductsService();
    }

    public function actionCreate(): array
    {
        $form = new ProductForm([
            'scenario' => Scenarious::CreateProduct
        ]);
        $form->load(Yii::$app->request->post(), '');
        if ($form->validate()) {
            $this->service->createProduct($form->productAttributes);
            return $this->jsonApi->setupCode(204)->asArray();
        }
        return $this->jsonApi->addModelErrors($form)->asArray();
    }

    public function actionUpdate(): array
    {
        $productForm = new ProductForm([
            'scenario' => Scenarious::UpdateProduct
        ]);
        $productForm->load(Yii::$app->request->post());
        if ($productForm->validate()) {
            $this->service->update($productForm);
            return $this->jsonApi->setupCode(204)->asArray();
//            try {
//
//            } catch (Throwable $throwable) {
//
//                return $this->jsonApi->addException($throwable)->asArray();
//            }
        }
        return $this->jsonApi->addModelErrors($productForm)->setupCode(422)->asArray();
    }

    public function actionRemove(): array
    {
        $form = new ProductForm([
            'scenario' => Scenarious::RemoveProduct
        ]);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->remove($form->id);
                return $this->jsonApi->setupCode(204)->asArray();
            } catch (Throwable $throwable) {
                return $this->jsonApi->addException($throwable)->asArray();
            }
        }
        return $this->jsonApi->addModelErrors($form)->asArray();
    }

    public function actionBatchCreateViaDocument(): array
    {
        $ini = ini_get('upload_max_filesize');
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
}