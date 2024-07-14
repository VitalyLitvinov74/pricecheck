<?php

namespace app\controllers\api;

use app\domain\ManageCategory\UseCases\CategoryService;
use app\domain\ManageParsingSchema\UseCases\ParsingSchemaService;
use app\forms\ParsingSchemaForm;
use app\forms\CategoryForm;
use yii\filters\VerbFilter;

class CategoryController extends BaseApiController
{
    private CategoryService $service;
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
        $this->service = new CategoryService();
        $this->parsingSchemaService = new ParsingSchemaService();
        parent::init();
    }

    public function actionCreate(): array
    {
        $productTypeForm = new CategoryForm();
        $productTypeForm->load($this->request->post());
        if ($productTypeForm->validate()) {
            $id = $this->service->create($productTypeForm);
            $this->jsonApi->addField('id', $id);
            $this->jsonApi->setupCode(200);
            return $this->jsonApi->asArray();
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
}