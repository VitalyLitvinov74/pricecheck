<?php

namespace app\domain\ParseDocument\Models;

use Doctrine\Common\Collections\ArrayCollection;

class XlsxFile
{
    public function __construct(string $path)
    {
    }

    /**
     * @return ArrayCollection<int, DataRow>
     */
    public function rows(): ArrayCollection{

    }
}