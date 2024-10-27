<?php

namespace app\controllers;

use app\domain\Product\UseCase\ProductsService;
use app\forms\CreateProductsViaDocumentForm;
use app\forms\ProductForm;
use app\forms\Scenarious;
use app\records\ProductsRecords;
use Throwable;
use Yii;
use yii\helpers\ArrayHelper;

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
        $form->load(['productAttributes' => Yii::$app->request->post()], '');
        if ($form->validate()) {
            $this->service->createProduct($form->productAttributes);
            return $this->jsonApi->setupCode(204)->asArray();
        }
        return $this->jsonApi->addModelErrors($form)->asArray();
    }

    public function actionIndex(): array{
        return ProductsRecords::find()
            ->with([
                'productAttributes'
            ])
            ->orderBy(['id'=>SORT_DESC])
            ->asArray()
            ->all();
    }

    public function actionRemove(int $id): array{
        $form = new ProductForm([
            'scenario' => Scenarious::RemoveProduct
        ]);
        if($form->load(Yii::$app->request->get()) && $form->validate()){
            try {
                $this->service->remove($form->id);
                return $this->jsonApi->setupCode(204)->asArray();
            }catch (Throwable $throwable){
                return $this->jsonApi->addException($throwable)->asArray();
            }
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
}