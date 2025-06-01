<?php

namespace app\modules\Product\application\Parsing;

use app\components\eventBus\EventBus;
use app\components\eventBus\EventName;
use app\libs\ObjectMapper\ObjectMapper;
use app\modules\Product\application\Parsing\Events\ProductParsedEvent;
use app\modules\Product\domain\Parsing\Document;
use app\modules\Product\domain\Parsing\Models\ProductCard;
use app\modules\Product\infrastructure\mappers\ProductCardToArray;
use app\modules\Product\infrastructure\repositories\Parsing\MappingSchemasRepository;
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\ORM;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use Yii;
use yii\helpers\ArrayHelper;


class ParsingService
{

    private Serializer $serializer;

    public function __construct(
        private MappingSchemasRepository $mappingSchemasRepository = new MappingSchemasRepository(),
        private EventBus $eventBus = new EventBus()
    )
    {
        $this->serializer =  new Serializer([new PropertyNormalizer(), new ObjectNormalizer()]);
    }

    /**
     * @param string $filePath
     * @param string $parsingSchemaId
     * @return void
     */
    public function parse(string $filePath, string $parsingSchemaId): void
    {
        if (!file_exists($filePath)) {
            throw new \Exception('Файл не найден');
        }

        $document = new Document($filePath);
        $mappingSchema = $this->mappingSchemasRepository->findBy($parsingSchemaId);
        $cards = $document->parseUse($mappingSchema)->toArray();

        foreach ($cards as $card) {
            $data = $this->serializer->normalize($card);
            $this->eventBus->publishEvent(
                EventName::ProductParsedFromFile,
                $data
            );
        }
    }
}