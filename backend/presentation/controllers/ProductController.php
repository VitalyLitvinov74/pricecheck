<?php

namespace app\presentation\controllers;

use app\application\Property\AttachSettingsToProperty;
use app\domain\Product\SubDomains\Property\Models\PropertySettingType;
use app\domain\Product\UseCase\ProductsService;
use app\infrastructure\records\pg\ProductsRecords;
use app\infrastructure\records\pg\PropertiesSettingsRecord;
use app\presentation\forms\CreateProductsViaDocumentForm;
use app\presentation\forms\ProductForm;
use app\presentation\forms\ProductSearchForm;
use app\presentation\forms\ProductsTableSettingsForm;
use app\presentation\forms\Scenarious;
use Throwable;
use Yii;
use yii\db\ActiveQuery;

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
        $searchForm = new ProductSearchForm();
        return  $searchForm->dataProvider()->getModels();
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

    public function actionListSettings(): array
    {
        $settings = PropertiesSettingsRecord::find()
            ->with(['property'])
            ->where(['setting_type_id' => [PropertySettingType::EnabledProductListCRM->value]])
            ->asArray()
            ->all();
        return $this->jsonApi->addBody($settings)->asArray();
    }

    public function actionCreateSettings():array
    {
        $form = new ProductsTableSettingsForm();
        $form->load(Yii::$app->request->post());
        if ($form->validate()) {
            $action = new AttachSettingsToProperty();
            $action->__invoke(94, []);
//            $this->service->createSetting($form);
            return $this->jsonApi->setupCode(204)->asArray();
        }
        return $this->jsonApi->addModelErrors($form)->asArray();
    }
}