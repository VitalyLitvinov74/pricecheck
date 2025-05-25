<?php

namespace app\modules\Product\domain\ParceDocument\ParseDocument\Models;

use Doctrine\Common\Collections\ArrayCollection;

class XlsxRow
{
    public function __construct(private array $row)
    {
    }

    public function numMoreThan(int $num): bool
    {
        return $this->rowNum() >= $num;
    }

    /**
     * @return ArrayCollection<int, XlsxCell>
     */
    public function cells(): ArrayCollection
    {
        $cellsCollection = new ArrayCollection();
        foreach ($this->row as $column) {
            $cellsCollection->add(
                new XlsxCell($this->rowNum(), $column['name'], $column['value'])
            );
        }
        return $cellsCollection;
    }

    private function rowNum(): int
    {
        return $this->row[0]['r']++;
    }
}