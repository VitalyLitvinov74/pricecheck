<?php

namespace app\controllers;

use app\domain\ParsingSchema\UseCases\ParsingSchemaService;
use app\domain\Property\UseCases\ProductPropertyService;
use app\domain\Type;
use app\forms\ParsingSchemaForm;
use app\forms\ProductPropertyForm;
use app\forms\ProductsPropertiesForm;
use app\forms\Scenarious;
use app\records\PropertiesRecord;
use Yii;
use yii\db\Exception;
use yii\filters\VerbFilter;

class PropertiesController extends BaseApiController
{
    private ProductPropertyService $service;
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
        parent::init();
    }

    public function actionCreate(): array
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

    public function actionAvailableTypes(){
        return $this->jsonApi->addBody([
            Type::Float->value,
            Type::String->value,
            Type::Decimal->value,
            Type::Int->value,
        ])
            ->setupCode(200)
            ->asArray();
    }

    public function actionRemove(){
        $form = new ProductPropertyForm([
            'scenario' => Scenarious::RemoveProperty->value
        ]);
        $form->load(Yii::$app->request->post());
        if($form->validate()){
            try{
                $this->service->remove($form->id);
                return $this->jsonApi->setupCode(204)->asArray();
            }catch (\Throwable $exception){
                return $this->jsonApi->addException($exception)->asArray();
            }

        }
        return $this->jsonApi->setupCode(422)->addModelErrors($form)->asArray();
    }

    public function actionList(){
        return $this->jsonApi
            ->setupCode(200)
            ->addBody(
                PropertiesRecord::find()
                    ->orderBy('id DESC')
                    ->asArray()
                    ->all()
            )
            ->asArray();
    }
}