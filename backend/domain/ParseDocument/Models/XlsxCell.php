<?php

namespace app\domain\ParseDocument\Models;

use app\domain\Type;

class XlsxCell
{
    /**
     * @param int $rowNum
     * @param string $coordinate имеется ввиду A1, B1, C4, DD3, WW2 ...
     * @param $value
     */
    public function __construct(private int $rowNum, private string $coordinate, private $value)
    {
    }

    public function valueBy(Type $convertToType): mixed
    {
        $value = $this->value;
//        settype($value, $convertToType->value); //todo опбратить внимание на тип
        return $value;
    }

    public function hasColumnName(string $comparedName): bool
    {
        return $this->columnName() == $comparedName;
    }

    private function columnName(): string
    {
        return strtolower(
            preg_replace('/[0-9]/','', $this->coordinate)
        );
    }

}