<?php

namespace app\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;

class PriceListController extends BaseController
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'logout' => ['post'],
            ],
        ];
        return $behaviors;
    }
}