<?php

use yii\mongodb\Connection;

return [
//    'db'=>[
//        'class' => 'yii\db\Connection',
//        'dsn' => 'mysql:host=mysql;dbname=pricecheck',
//        'username' => 'root',
//        'password' => 'root',
//        'charset' => 'utf8',
//    ],

    'mongodb' => [
        'class' => Connection::class,
        'dsn' => 'mongodb://mongo:27017/pricecheck',
        'options' => [
            "username" => "root",
            "password" => "root"
        ]
    ],
];