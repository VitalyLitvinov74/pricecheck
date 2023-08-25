<?php

namespace app\domain\ParseProduct;

use app\domain\ParseProduct\Model\DataSource;
use app\domain\ParseProduct\Model\ParseSchema;
use Doctrine\Common\Collections\ArrayCollection;
use Product;

class CatalogOfParsedProducts
{
    /** @var ArrayCollection<int, Product> */
    private ArrayCollection $products;
    private ArrayCollection $parseShemas;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function loadProducts(DataSource $dataSource, ParseSchema $parseSchema): void
    {
        $data = $dataSource->data();
        $products = $parseSchema->convertToProduct(

        );

    }
}