<?php

use app\components\cycle\Cycle;
use app\modules\Product\application\Product\ProductService;
use app\modules\Product\infrastructure\repositories\Product\ProductPgRepository;
use app\modules\UserSettings\application\SettingsService;
use app\modules\UserSettings\infrastructure\repositories\UserRepository;

return [
    'singletons'=>[
        ProductService::class => ProductService::class,
        ProductPgRepository::class => ProductPgRepository::class,
        Cycle::class => Cycle::class,
        UserRepository::class => UserRepository::class,
        SettingsService::class => SettingsService::class,
    ]
];