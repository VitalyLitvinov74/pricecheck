<?php

use app\components\cycle\Cycle;
use app\components\eventBus\EventBus;
use mikemadisonweb\rabbitmq\Configuration;
use yii\db\Connection;

return [
    'db' => [
        'class' => Connection::class,
        'dsn' => 'pgsql:host=postgres;dbname=pricecheck',
        'username' => 'admin',
        'password' => 'admin',
        'charset' => 'utf8',
    ],
    'elasticsearch' => [
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
    'rabbitmq' => [
        'class' => Configuration::class,
        'connections' => [
            [
                // You can pass these parameters as a single `url` option: https://www.rabbitmq.com/uri-spec.html
                'host' => 'rabbitmq',
                'port' => '5672',
                'user' => 'rmuser',
                'password' => 'rmpassword',
                'name' => 'rabbitmq-connection'
            ]
            // When multiple connections is used you need to specify a `name` option for each one and define them in producer and consumer configuration blocks
        ],
        'exchanges' => [
            [
                'name' => 'all-events',
                'type' => 'topic'
                // Refer to Defaults section for all possible options
            ],
        ],
        'queues' => [
            [
                'name' => 'events',
            ],
        ],
        'bindings' => [
            [
                'queue' => 'events',
                'exchange' => 'all-events',
                'routing_keys' => ['events.#'],
            ],
        ],
        'producers' => [
            [
                'name' => 'events-producer',
                'connection' => 'rabbitmq-connection',
                'safe' => true,
                'content_type' => 'application/json',
                'delivery_mode' => 2,
            ],
        ],
        'consumers' => [
            [
                'name' => 'consumer-of-events',
                'connection' => 'rabbitmq-connection',
                'callbacks' => [
                    'events' => EventBus::class,
                ],
            ],
        ],
    ],
    'cycle' => [
        'class' => Cycle::class,
    ]
];