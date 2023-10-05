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
    'db2'=>[
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=mysql2;dbname=price2check',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
    ],
    'cycle'=>[
        'class'=> CycleComponent::class,
    ]
];