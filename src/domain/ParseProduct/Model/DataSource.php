<?php

namespace app\domain\ParseProduct\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Product;

class DataSource implements DataSourceInterface
{
    /** @var ArrayCollection<int, Product>  */
    private ArrayCollection $products;

    public function __construct(private string $path)
    {
    }

    public function data(): void{

    }
}