<?php

namespace app\infrastructure\libs\ObjectMapper\Mapping\MappingModes;

class DefaultModeStrategyMode implements MappingModeStrategyInterface
{

    /**
     * @param mixed $from
     * @param mixed $to
     *
     * @return void
     */
    public function map(mixed $from, mixed &$to): void
    {
        $to = $from;
    }
}