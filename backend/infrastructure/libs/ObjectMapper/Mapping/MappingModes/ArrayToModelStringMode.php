<?php

namespace app\infrastructure\libs\ObjectMapper\Mapping\MappingModes;

use app\infrastructure\libs\ObjectMapper\Mapping\Exceptions\ImpossibleIsNotMapping;
use app\infrastructure\libs\ObjectMapper\ReflectionTrait;
use Exception;

class ArrayToModelStringMode implements MappingModeStrategyInterface
{
    use ReflectionTrait;

    private ArrayToModelMode $origin;

    public function __construct()
    {
        $this->origin = new ArrayToModelMode();
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
        if (!is_array($from)) {
            throw new ImpossibleIsNotMapping(
                'Не возможно произвести маппинг, поскольку мы должны мапить из массива в модель. Однако на вход мы получаем не массив.'
            );
        }
        if (!is_string($to)) {
            throw new ImpossibleIsNotMapping(
                'Не возможно произвести маппинг, поскольку мы должны мапить из массива в модель. Однако на вход было передано не имя класса (Model::class) модели.'
            );
        }

        $modelReflectionClass = $this->getReflectionClass($to);
        try {
            $to = $modelReflectionClass->newInstanceWithoutConstructor();
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