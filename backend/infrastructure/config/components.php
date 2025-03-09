<?php

use app\infrastructure\cycle\Cycle;
use yii\db\Connection;

return [
    'db' => [
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
    'elastic' => [
        'class' => \yii\elasticsearch\Connection::class,
        'nodes' => [
            ['http_address' => 'elasticsearch:9200'],
            // configure more hosts if you have a cluster
        ],
        'auth' => [
            'username' => 'elastic',
            'password' => 'MyPw123'
        ],
        'dslVersion' => 8, // default is 5
    ],
];