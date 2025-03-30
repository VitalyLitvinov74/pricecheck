<?php

namespace app\infrastructure\repositories\ProductTemplate\pivots;

use app\domain\ProductTemplate\Models\Property;

class ProductTemplatesProperties
{
    private int $id;
    private int $templateId;
    private int $propertyId;

    private function __construct()
    {
    }
}