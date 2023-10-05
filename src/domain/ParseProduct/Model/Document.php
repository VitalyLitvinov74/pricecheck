<?php

namespace app\domain\ParseProduct\Model;

use Doctrine\Common\Collections\ArrayCollection;

class Document
{
    public function __construct(string $path, ParsingSchema $parseSchema)
    {
    }

    /**
     * @return ArrayCollection<int, Product>
     */
    public function parse(): ArrayCollection{

    }
}