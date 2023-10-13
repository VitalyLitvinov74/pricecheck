<?php

namespace app\domain\ParseDocument\Models;

use Doctrine\Common\Collections\ArrayCollection;
use Shuchkin\SimpleXLSX;

class XlsxFile
{
    public function __construct(private string $path)
    {
    }

    /**
     * @return ArrayCollection<int, DataRow>
     */
    public function rows(): ArrayCollection{
        /** @var SimpleXLSX $xlsx */
        $xlsx = SimpleXLSX::parseFile($this->path);
        $collection = new ArrayCollection();
        foreach ($xlsx->readRows() as $row){
            $collection->add(
                new DataRow($row)
            );
        }
        return $collection;
    }
}