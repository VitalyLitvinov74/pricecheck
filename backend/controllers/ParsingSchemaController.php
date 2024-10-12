<?php

namespace app\controllers;

use app\domain\ParsingSchema\UseCases\ParsingSchemaService;
use app\forms\ParsingSchemaForm;
use app\records\ParsingSchemasRecord;
use Yii;

class ParsingSchemaController extends BaseApiController
{
    private ParsingSchemaService $service;

    public function init(): void
    {
        parent::init();
        $this->service = new ParsingSchemaService();
    }

    public function actionCreate()
    {
        $form = new ParsingSchemaForm();
        $form->load(Yii::$app->request->post());
        if ($form->validate()) {
            $this->service->create(
                $form->name,
                $form->startWithRowNum,
                $form->map
            );
            return $this->jsonApi->setupCode(204)->asArray();
        }
        return $this->jsonApi->addModelErrors($form)->asArray();
    }

    public function actionIndex()
    {
        return $this->jsonApi
            ->addBody(
                ParsingSchemasRecord::find()
                    ->with(['parsingSchemaProperties'])
                    ->asArray()
                    ->all()
            )
            ->asArray();
    }
}