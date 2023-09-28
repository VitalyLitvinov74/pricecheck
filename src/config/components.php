<?php

use app\components\cycle\CycleComponent;
use yii\mongodb\Connection;

return [
    'db'=>[
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=mysql;dbname=pricecheck',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
    ],
    'cycle'=>[
        'class'=> CycleComponent::class,
    ]
];