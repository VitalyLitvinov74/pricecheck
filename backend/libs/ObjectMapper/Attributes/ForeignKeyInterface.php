<?php

namespace app\libs\ObjectMapper\Attributes;

interface ForeignKeyInterface
{
    public function key(): string;
}