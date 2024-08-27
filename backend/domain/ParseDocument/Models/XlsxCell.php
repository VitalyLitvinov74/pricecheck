<?php

namespace app\domain\ParseDocument\Models;

use app\domain\Type;

class XlsxCell
{
    public function __construct(private int $rowNum, private string $columnName, private $value)
    {
    }

    public function valueBy(Type $convertToType): mixed
    {
        $value = $this->value;
        settype($value, $convertToType->value);
        return $value;
    }

    public function hasColumnName(string $comparedName): bool
    {
        return strtolower($this->columnName) == strtolower($comparedName);
    }

}