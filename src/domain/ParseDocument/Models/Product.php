<?php

namespace app\domain\ParseDocument\Models;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity(table: 'products')]
#[Column(type: 'integer', name: 'id', primary: true)]
class Product
{

}