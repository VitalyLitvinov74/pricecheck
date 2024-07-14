<?php

namespace app\controllers\api;

use app\domain\ManageCategories\UseCases\CategoryService;
use app\forms\ParsingSchemaForm;
use app\forms\CategoryForm;
use yii\filters\VerbFilter;

class CategoryController extends BaseApiController
{
    private CategoryService $service;
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
            $this->->addParsingSchemaTo(
                $schemaForm->name,
                $schemaForm->startWithRowNum,
                $schemaForm->map,
                $schemaForm->productTypeId
            );
            return $this->jsonApi->asArray();
        }
        return $this->jsonApi
            ->addModelErrors($schemaForm)
            ->asArray();
    }
}