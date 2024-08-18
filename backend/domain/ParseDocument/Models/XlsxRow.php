<?php

namespace app\domain\ParseDocument\Models;

use Doctrine\Common\Collections\ArrayCollection;

class XlsxRow
{
    private int $rowNum;

    public function numMoreThan(int $num): bool
    {
        return $this->rowNum >= $num;
    }

    /**
     * @return ArrayCollection<int, XlsxCell>
     */
    public function cells(): ArrayCollection
    {

    }
}