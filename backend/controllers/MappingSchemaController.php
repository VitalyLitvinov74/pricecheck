<?php

namespace app\controllers;

use app\forms\MappingSchemaForm;
use app\records\MappingSchemaCollection;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;

class MappingSchemaController extends Controller
{
    //public function behaviors(): array
    //{
    //    $behaviors = parent::behaviors();
    //    $behaviors['verbs'] = [
    //        'class' => VerbFilter::class,
    //        'actions' => [
    //            'logout' => ['post'],
    //        ],
    //    ];
    //    return $behaviors;
    //}

    public function actionIndex(): string
    {
        return $this->render('index',
            [
                'dataProvider' => new ActiveDataProvider([
                    'query' => MappingSchemaCollection::find()
                ])
            ]
        );
    }

    public function actionCreate()
    {
        $form = new MappingSchemaForm();
        $form->load(Yii::$app->request->post());
        if($form->validate()){
            ///
        }
        return $this->render('create', [
            'form' => $form
        ]);
    }

    public function actionUpdate()
    {

    }

    public function actionDelete()
    {

    }
}