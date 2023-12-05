<?php

namespace app\domain\ManageProductType\Models;

class CardField
{
    public function __construct(
        private string $name,
        private string $type
    ) {
    }
}