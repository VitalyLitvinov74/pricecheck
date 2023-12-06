<?php

namespace app\libs\ObjectMapper\Mapping\MappingModes;

interface MappingModeStrategyInterface
{
    public function map(mixed $from, mixed &$to): void;
}