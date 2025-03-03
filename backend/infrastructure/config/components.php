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
    ],
    'elasticsearch' => [
        'class' => 'yii\elasticsearch\Connection',
        'nodes' => [
            ['http_address' => '127.0.0.1:9200'],
            // configure more hosts if you have a cluster
        ],
        'dslVersion' => 7, // default is 5
    ],
];