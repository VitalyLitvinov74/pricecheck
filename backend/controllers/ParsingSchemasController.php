<?php

namespace app\controllers;

use app\domain\ParsingSchema\UseCases\ParsingSchemaService;
use app\forms\ParsingSchemaForm;
use app\forms\Scenarious;
use app\records\ParsingSchemaRecord;
use Yii;

class ParsingSchemasController extends BaseApiController
{
    private ParsingSchemaService $service;

    public function init(): void
    {
        parent::init();
        $this->service = new ParsingSchemaService();
    }

    public function actionCreate()
    {
        $form = new ParsingSchemaForm(['scenario'=>Scenarious::CreateParsingSchema]);
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
                ParsingSchemaRecord::find()
                    ->with([
                        'parsingSchemaProperties',
                        'parsingSchemaProperties.property'
                    ])
                    ->asArray()
                    ->all()
            )
            ->asArray();
    }

    public function actionView(int $id)
    {
        $schema = ParsingSchemaRecord::find()
            ->with([
                'parsingSchemaProperties',
            ])
            ->where(['id' => $id])
            ->asArray()
            ->one();

        if ($schema) {
            return $this->jsonApi
                ->addBody($schema)
                ->asArray();
        }
        return $this->jsonApi
            ->addBody(null)
            ->setupCode(404)
            ->asArray();
    }

    public function actionUpdate(): array
    {
        $form = new ParsingSchemaForm(['scenario' => Scenarious::UpdateParsingSchema]);
        $form->load(Yii::$app->request->post());
        if($form->validate()){
            $this->service->update();
        }
    }
}