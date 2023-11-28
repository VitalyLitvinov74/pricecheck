<?php

namespace app\controllers;

use app\records\MappingSchemaRecord;
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
                    'query' => MappingSchemaRecord::find()
                ])
            ]
        );
    }

    public function actionCreate()
    {

    }

    public function actionUpdate()
    {

    }

    public function actionDelete()
    {

    }
}