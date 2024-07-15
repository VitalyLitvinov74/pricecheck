<?php

use yii\db\Connection;

return [
    'db'=>[
        'class' => Connection::class,
        'dsn' => 'pgsql:host=postgres;dbname=pricecheck',
        'username' => 'admin',
        'password' => 'admin',
        'charset' => 'utf8',
    ],
    'mongodb' => [
        'class' => \yii\mongodb\Connection::class,
        'dsn' => 'mongodb://mongo:27017/pricecheck',
        'options' => [
            "username" => "admin",
            "password" => "admin"
        ]
    ]
];