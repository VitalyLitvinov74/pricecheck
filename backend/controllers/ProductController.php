<?php

namespace app\controllers;

use app\domain\Product\UseCase\ProductsService;
use app\domain\Property\Models\PropertySettingType;
use app\domain\Property\UseCases\ProductPropertyService;
use app\forms\CreateProductsViaDocumentForm;
use app\forms\ProductForm;
use app\forms\ProductListSettingsForm;
use app\forms\Scenarious;
use app\records\ProductsRecords;
use app\records\PropertiesSettingsRecord;
use Throwable;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Query;

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

    public function actionIndex(): array
    {
        return ProductsRecords::find()
            ->with([
                'productAttributes' => function (Query $query) {
                    $query->where([
                        'property_id' => PropertiesSettingsRecord::find()
                            ->select(['property_id'])
                            ->where(['setting_type_id' => [
                                PropertySettingType::OnInProductListCRM->value
                            ]])
                    ]);
                }
            ])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();
    }

    public function actionView(int $id): array
    {
        return ProductsRecords::find()
            ->with([
                'productAttributes' => function (ActiveQuery $query) {
                    $query->select([
                        'id',
                        'name' => 'property_name',
                        'propertyId' => 'property_id',
                        'value',
                        'product_id'
                    ]);
                }
            ])
            ->where(['id' => $id])
            ->asArray()
            ->one();
    }

    public function actionUpdate(): array
    {
        $productForm = new ProductForm([
            'scenario' => Scenarious::UpdateProduct
        ]);
        $productForm->load(Yii::$app->request->post());
        if ($productForm->validate()) {
            try {
                $this->service->update($productForm);
                return $this->jsonApi->setupCode(204)->asArray();
            } catch (Throwable $throwable) {
                return $this->jsonApi->addException($throwable)->asArray();
            }
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

    public function actionListSettings(): array
    {
        $settings = PropertiesSettingsRecord::find()
            ->with(['property'])
            ->where(['setting_type_id' => [PropertySettingType::OnInProductListCRM->value]])
            ->asArray()
            ->all();
        return $this->jsonApi->addBody($settings)->asArray();
    }
}