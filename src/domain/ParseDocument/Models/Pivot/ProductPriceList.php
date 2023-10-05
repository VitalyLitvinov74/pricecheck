<?php

namespace app\domain\ParseDocument\Models\Pivot;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity(table: 'product_price_list', database: 'db2')]
#[Column(type: 'integer', name: 'product_id', primary: true)]
#[Column(type: 'integer', name: 'price_list_id', primary: true)]
class ProductPriceList
{

}