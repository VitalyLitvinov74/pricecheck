<?php

namespace app\domain\ParseDocument\Models;

class MappingSchema
{
    public function loadValue(string $key, string|float $value): void{

    }

    public function convertToProduct(): Product{
        return new Product();
    }

    public function extractData(DataRow $row): void{
        $row->loadToSchema($this);
    }
}