<?php

namespace app\domain\Product\Persistance;

use app\collections\ProductPropertyCollection;
use app\domain\Product\Models\Property;
use app\domain\Type;
use app\libs\ObjectMapper\ObjectMapper;
use yii\base\Exception;

class PropertyRepository
{
    private array $properties;

    public function __construct(private ObjectMapper $objectMapper = new ObjectMapper())
    {
        $this->properties = [];
    }

    public function idByName(string $name): string
    {
        $this->loadProperties();
        foreach ($this->properties as $property) {
            if ($name === $property['name']) {
                return $property["_id"];
            }
        }
        throw new Exception(
            sprintf('Не найдено свойство %s', $name),
            404
        );
    }

    public function exist(string $id): bool
    {
        $this->loadProperties();
        foreach ($this->properties as $property) {
            if ((string) $property['_id'] === $id) {
                return true;
            }
        }
        return false;
    }

    private function loadProperties(): void
    {
        if ($this->properties === []) {
            $this->properties = ProductPropertyCollection::find()->asArray()->all();
        }
    }
}