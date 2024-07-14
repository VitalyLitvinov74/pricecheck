<?php

namespace app\domain\ParseDocument\Models;

class MappingPair
{
    private string $externalName;
    private string $name;
    private string $type;

    private function __construct() { }

    public function externalName(): string
    {
        return strtolower($this->externalName);
    }

    public function name(): string
    {
        return strtolower($this->name);
    }

    public function type(): string
    {
        return strtolower($this->name);
    }
}