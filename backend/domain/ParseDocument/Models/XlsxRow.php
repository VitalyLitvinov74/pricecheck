<?php

namespace app\domain\ParseDocument\Models;

use Doctrine\Common\Collections\ArrayCollection;

class XlsxRow
{
    public function numMoreThan(int $num): bool
    {

    }

    /**
     * @return ArrayCollection<int, XlsxCell>
     */
    public function cells(): ArrayCollection
    {

    }
}