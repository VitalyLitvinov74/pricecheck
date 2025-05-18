<?php

use app\components\cycle\Cycle;
use app\modules\Product\application\ProductService;
use app\modules\Product\infrastructure\repositories\ProductPgRepository;
use app\modules\UserSettings\infrastructure\repositories\UserRepository;

return [
    'singletons'=>[
        ProductService::class => ProductService::class,
        ProductPgRepository::class => ProductPgRepository::class,
        Cycle::class => Cycle::class,
        UserRepository::class => UserRepository::class
    ]
];