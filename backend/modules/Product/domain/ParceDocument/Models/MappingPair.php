<?php

namespace app\modules\Product\domain\ParceDocument\Models;

use app\domain\Type;
use app\libs\ObjectMapper\Attributes\DomainModel;
use app\libs\ObjectMapper\Attributes\Property;

class MappingPair
{
    private string $externalName;
    private int $propertyId;
    private Type $type;

    private function __construct() { }

    public function externalName(): string
    {
        return strtolower(
            preg_replace('/[0-9]/', '', $this->externalName)
        );
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