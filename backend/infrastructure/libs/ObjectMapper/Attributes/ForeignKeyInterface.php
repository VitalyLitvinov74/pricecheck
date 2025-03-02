<?php

namespace app\infrastructure\libs\ObjectMapper\Attributes;

interface ForeignKeyInterface
{
    public function key(): string;
}