<?php

use app\infrastructure\cycle\Cycle;
use yii\db\Connection;

return [
    'db'=>[
        'class' => Connection::class,
        'dsn' => 'pgsql:host=postgres;dbname=pricecheck',
        'username' => 'admin',
        'password' => 'admin',
        'charset' => 'utf8',
    ],
    'cycle' => [
        'class' => Cycle::class,
        'dsn' => 'pgsql:host=postgres;dbname=pricecheck',
        'username' => 'admin',
        'password' => 'admin',
    ]
];