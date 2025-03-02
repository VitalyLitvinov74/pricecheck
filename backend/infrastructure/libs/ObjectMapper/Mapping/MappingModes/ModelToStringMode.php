<?php

namespace app\infrastructure\libs\ObjectMapper\Mapping\MappingModes;

use app\infrastructure\libs\ObjectMapper\Mapping\Exceptions\ImpossibleIsNotMapping;
use app\infrastructure\libs\ObjectMapper\ReflectionTrait;
use Exception;

class ModelToStringMode implements MappingModeStrategyInterface
{
    use ReflectionTrait;

    private ModelToObjectMode $origin;

    public function __construct()
    {
        $this->origin = new ModelToObjectMode();
    }

    /**
     * @param mixed $from
     * @param mixed $to
     *
     * @return void
     * @throws ImpossibleIsNotMapping
     */
    public function map(mixed $from, mixed &$to): void
    {
        if (!is_object($from)) {
            throw new ImpossibleIsNotMapping(
                'Не возможно произвести маппинг, поскольку мы должны мапить из модели в объект. Однако на вход мы получаем не объект модели'
            );
        }
        if (!is_string($to)) {
            throw new ImpossibleIsNotMapping(
                'Не возможно произвести маппинг, поскольку мы должны мапить из модели в объект. Однако на вход мы получаем не имя класса (Object::class) объекта'
            );
        }

        $toReflectionClass = $this->getReflectionClass($to);
        try {
            $to = $toReflectionClass->newInstanceWithoutConstructor();
        } catch (Exception $exception) {
            throw throw new ImpossibleIsNotMapping(
                sprintf(
                    'Не возможно произвести маппинг, поскольку не возможно создать объект %s без конструктора',
                    $to
                )
            );
        }
        $this->origin->map($from, $to);
    }
}