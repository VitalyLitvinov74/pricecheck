<?php

namespace app\modules\Product\application\Parsing;

use app\components\eventBus\EventBus;
use app\modules\Product\application\Parsing\Events\ProductParsedEvent;
use app\modules\Product\domain\Parsing\Document;
use app\modules\Product\domain\Parsing\Models\ProductCard;
use app\modules\Product\infrastructure\repositories\Parsing\MappingSchemasRepository;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use yii\helpers\ArrayHelper;


class ParsingService
{
    private Serializer $serializer;

    public function __construct(
        private MappingSchemasRepository $mappingSchemasRepository,
        private EventBus $eventBus
    )
    {
        $this->serializer = new Serializer([new ObjectNormalizer()]);
    }

    /**
     * @param string $filePath
     * @param string $passedName
     * @param string $parsingSchemaId
     * @return void
     */
    public function parse(string $filePath, string $parsingSchemaId): void
    {
        $document = new Document($filePath);
        $mappingSchema = $this->mappingSchemasRepository->findBy($parsingSchemaId);
        $cards = $document->parseUse($mappingSchema)->toArray();

        foreach ($cards as $card) {
            $this->eventBus->publishEvent(
                $this->convertToEvent($card)
            );
        }
    }

    private function convertToEvent(ProductCard $card): ProductParsedEvent
    {
        $array = $this->serializer->normalize($card);
        return new ProductParsedEvent(
            ArrayHelper::getValue($array, 'parsingVersion'),
            ArrayHelper::getValue($array, 'attributes')
        );
    }
}