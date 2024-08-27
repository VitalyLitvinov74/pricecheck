<?php

namespace app\domain\ParseDocument\Models;

use app\domain\Type;

class MappingPair
{
    private string $externalName;
    private string $propertyId;
    private Type $type;

    private function __construct() { }

    public function externalName(): string
    {
        return strtolower($this->externalName);
    }

    public function propertyId(): string
    {
        return strtolower($this->propertyId);
    }

    public function convertCell()
    {
        
    }

    public function type(): Type
    {
        return $this->type;
    }
}