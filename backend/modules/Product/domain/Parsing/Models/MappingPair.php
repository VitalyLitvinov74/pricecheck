<?php

namespace app\modules\Product\domain\Parsing\Models;

use app\domain\Type;

class MappingPair
{
    private string $externalName;

    private Property $property;

    private function __construct() { }

    public function externalName(): string
    {
        return strtolower(
            preg_replace('/[0-9]/', '', $this->externalName)
        );
    }

    public function propertyId(): string
    {
        return strtolower($this->property->id());
    }

    public function convertCell()
    {
        
    }

    public function type(): Type
    {
        return $this->property->type();
    }
}