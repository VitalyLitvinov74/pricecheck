<?php

namespace app\domain\ParseDocument\Models;

class XlsxCell
{
    public function __construct(private int $rowNum, private string $columnName, private $value)
    {
    }

    public function value(string $convertToType): mixed
    {
        $value = $this->value;
        settype($value, $convertToType);
        return $value;
    }

    public function hasName(string $comparedName): bool
    {

    }

}