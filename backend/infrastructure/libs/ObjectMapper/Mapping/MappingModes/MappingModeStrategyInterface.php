<?php

namespace app\infrastructure\libs\ObjectMapper\Mapping\MappingModes;

interface MappingModeStrategyInterface
{
    public function map(mixed $from, mixed &$to): void;
}