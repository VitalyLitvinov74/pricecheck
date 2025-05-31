<?php

namespace app\modules\Product\application\Parsing\Events;

use app\components\eventBus\Event;

class ProductParsedEvent extends Event
{
    /**
     * @param string $parsingVersion
     * @param array $attributes
     */
    public function __construct(
        string $parsingVersion,
        array $attributes
    )
    {
    }
}