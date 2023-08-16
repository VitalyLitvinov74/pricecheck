<?php

use yii\mongodb\Connection;

return [
    'mongodb' => [
        'class' => Connection::class,
        'dsn' => 'mongodb://mongo:27017/pricecheck',
        'options' => [
            "username" => "root",
            "password" => "root"
        ]
    ],
    'db'=>[
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=mysql;dbname=pricecheck',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
    ]
];