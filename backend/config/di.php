<?php

use app\components\cycle\Cycle;
use app\modules\Product\application\ProductService;
use app\modules\Product\infrastructure\repositories\ProductPgRepository;

return [
    'singletons'=>[
        ProductService::class => ProductService::class,
        ProductPgRepository::class => ProductPgRepository::class,
        Cycle::class => Cycle::class
    ]
];