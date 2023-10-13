<?php

namespace app\domain\ParseDocument\Models;

class DataRow
{
    public function __construct(private array $rowData)
    {

    }

    public function convertToProduct(MappingSchema $mappingSchema): Product
    {
        foreach ($this->rowData as $columnName => $value){
            if($mappingSchema->hasColumnName)
        }
    }
}