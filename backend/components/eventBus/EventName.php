<?php

namespace app\components\eventBus;

abstract class EventName
{
    /**
     * @var array{
     *      parsingVersion: string,
     *       attributes: array{
     *           propertyId: int,
     *           value: string,
     *       }
     *     }
     */
    const ProductParsedFromFile = 'product.parsed.from.file';
}