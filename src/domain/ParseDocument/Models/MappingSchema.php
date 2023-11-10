<?php

namespace app\domain\ParseDocument\Models;

use app\domain\ParseDocument\Snapshots\MappingSchemaSnapshot;
use Doctrine\Common\Collections\ArrayCollection;

class MappingSchema
{
    private ArrayCollection $loadedValues;

    private function __construct()
    {
    }

    public function loadValue(string $key, string|float $value): void
    {
        $this->loadedValues->set($key, $value);
    }

    public function buildProduct(): Product
    {
        $this->loadedValues->clear();
        return new Product();
    }

    public function makeSnapshot(): MappingSchemaSnapshot
    {
    }
}