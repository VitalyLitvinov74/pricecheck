<?php

namespace app\domain\Product\Persistance;

use app\collections\ProductPropertyCollection;
use app\domain\Product\Models\Property;
use app\libs\ObjectMapper\ObjectMapper;

class PropertyRepository
{
    public function __construct(private ObjectMapper $objectMapper = new ObjectMapper())
    {
    }

    public function findBy(string $idOrName): Property
    {
        $result = ProductPropertyCollection::find()
            ->select([
                'supportProperties'
            ])
            ->where([
                'or',
                ['id' => $idOrName],
                ['name' => $idOrName]
            ])
            ->asArray()
            ->one();
        return $this->objectMapper->map($result, Category::class);
    }
}