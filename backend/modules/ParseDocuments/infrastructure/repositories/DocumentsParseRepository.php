<?php

namespace app\modules\ParseDocuments\infrastructure\repositories;

use app\components\eventBus\EventBus;
use app\modules\ParseDocuments\application\events\ProductParsedEvent;
use app\modules\Product\domain\ParceDocument\Models\ProductCard;

class DocumentsParseRepository
{
    public function __construct(private EventBus $eventBus)
    {
    }

    /**
     * @param ProductCard[] $productCards
     * @return void
     */
    public function send(array $productCards): void
    {
        foreach ($productCards as $productCard) {
            $this->eventBus->publishEvent(
                new ProductParsedEvent()
            );
        }
    }
}