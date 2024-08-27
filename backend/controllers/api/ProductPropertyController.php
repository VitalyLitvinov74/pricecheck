<?php

namespace app\controllers\api;

use app\domain\ParsingSchema\UseCases\ParsingSchemaService;
use app\domain\ProductProperty\UseCases\ProductPropertyService;
use app\forms\ParsingSchemaForm;
use app\forms\ProductsPropertiesForm;
use yii\db\Exception;
use yii\filters\VerbFilter;

class ProductPropertyController extends BaseApiController
{
    private ProductPropertyService $service;
    private ParsingSchemaService $parsingSchemaService;
    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'product-type' => ['post'],
                ],
            ]
        ]);
    }

    public function init(): void
    {
        $this->service = new ProductPropertyService();
        $this->parsingSchemaService = new ParsingSchemaService();
        parent::init();
    }

    public function actionCreateList(): array
    {
        $productTypeForm = new ProductsPropertiesForm();
        $productTypeForm->load($this->request->post());
        if ($productTypeForm->validate()) {
            try {
                $this->service->push($productTypeForm->properties);
                $this->jsonApi->setupCode(204);
                return $this->jsonApi->asArray();
            }catch (Exception $exception){
                return $this->jsonApi->addException($exception)->asArray();
            }
        }
        return $this->jsonApi->addModelErrors($productTypeForm)->asArray();
    }

    public function actionAddParsingSchema(): array{
        $schemaForm = new ParsingSchemaForm();
        $schemaForm->load($this->request->post());
        if($schemaForm->validate()){
            $this->parsingSchemaService->create(
                $schemaForm->categoryId,
                $schemaForm->name,
                $schemaForm->startWithRowNum,
                $schemaForm->map,

            );
            return $this->jsonApi->asArray();
        }
        return $this->jsonApi
            ->addModelErrors($schemaForm)
            ->asArray();
    }

    public function actionUpdateParsingSchema(): array{
        $schemaForm = new ParsingSchemaForm();
        $schemaForm->load($this->request->post());
        if($schemaForm->validate()){
            $this->parsingSchemaService->update(
                $schemaForm->categoryId,
                $schemaForm->name,
                $schemaForm->startWithRowNum,
                $schemaForm->map,
            );
            return $this->jsonApi->asArray();
        }
        return $this->jsonApi
            ->addModelErrors($schemaForm)
            ->asArray();
    }
}