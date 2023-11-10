<?php

namespace app\domain\ParseDocument\Models;

use app\domain\ParseDocument\Snapshots\ProductSnapshot;

class Product
{
    public function __construct()
    {
    }

    public function makeSnapshot(): ProductSnapshot{

    }
}