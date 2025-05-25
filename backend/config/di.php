<?php

use app\components\cycle\Cycle;
use app\modules\Product\application\DocumentsParseService;
use app\modules\Product\application\ProductService;
use app\modules\Product\domain\ParceDocument\Persistance\MappingSchemasRepository;
use app\modules\Product\infrastructure\repositories\ProductPgRepository;
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