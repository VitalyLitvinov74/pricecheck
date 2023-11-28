<?php

namespace app\libs\ObjectMapper;

use app\libs\IdentityMap;
use app\libs\ObjectMapper\Mapping\MappingModes\ArrayToModelMode;
use app\libs\ObjectMapper\Mapping\MappingModes\ArrayToModelStringMode;
use app\libs\ObjectMapper\Mapping\MappingModes\DefaultModeStrategyMode;
use app\libs\ObjectMapper\Mapping\MappingModes\MappingModeStrategyInterface;
use app\libs\ObjectMapper\Mapping\MappingModes\ModelToObjectMode;
use app\libs\ObjectMapper\Mapping\MappingModes\ModelToStringMode;

/**
 * @template T
 */
class ObjectMapper
{
    use ReflectionTrait;

    /**
     * @var IdentityMap|null  - нужна прежде всего чтобы в разные модели вставлять
     * один и тот же экземпляр класса и не создавать новый.
     * например, если в Company есть Manager и у звонка есть Manager, то без использования IdentityMap
     * Manager === Manager (false) т.к. экземпляры классов будут разные
     * Если используем идентити - то каждый раз, когда к нам на вход будут приходить одинаковые значения,
     * для маппинга в Manager, то мы просто возращаем того Manager который был создан при первой передаче данных.
     * и следовательно Manager === Manager (true), т.к. это будет один и тот же экземпляр класса.
     */
    private static IdentityMap|null $identityMap = null;

    public function __construct()
    {
        if (self::$identityMap === null) {
            /**
             * создаем статическую карту для контекста Object Mapper
             * таким образом в карте будут храниться и вложенные модели.
             */
            self::$identityMap = new IdentityMap();
        }
    }

    /**
     * @param object|array $from
     * @param string|object|array $to
     * @param bool $isNestedMapping если false - то маппинг происходит с очищением кеша. т.е. при каждом клиентском
     *     вызове метода Identity Cache будет очищаться
     *
     * @psalm-param T $to
     * @return T|array
     */
    public function map(
        object|array $from,
        string|object|array $to,
        bool $isNestedMapping = false
    ): object|array {
        if (self::$identityMap->has($from)) {
            return self::$identityMap->relationOf($from);
        }
        $strategy = $this->defineMappingStrategy($from, $to);
        $strategy->map($from, $to);
        self::$identityMap->makeRelation($from, $to);
        if (!$isNestedMapping) {
            self::$identityMap->clear(); //после каждого не внутреннего (клиентского) вызова - чистим карту
        }
        return $to;
    }

    private function defineMappingStrategy(object|array $from, array|object|string $to): MappingModeStrategyInterface
    {
        if (is_object($from) && is_object($to)) {
            return new ModelToObjectMode();
        }
        if (is_object($from) && is_string($to)) {
            return new ModelToStringMode();
        }
        if (is_array($from) && is_array($to)) {
            return new DefaultModeStrategyMode();
        }

        if (is_array($from) && is_object($to)) {
            return new ArrayToModelMode();
        }

        if (is_array($from) && is_string($to)) {
            return new ArrayToModelStringMode();
        }

        return new DefaultModeStrategyMode();
    }
}