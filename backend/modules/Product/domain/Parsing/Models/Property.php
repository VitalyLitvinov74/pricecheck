<?php

namespace app\modules\Product\domain\Parsing\Models;

use app\domain\Type;

class Property
{
    private int $id;
    private Type $type;

    private function __construct()
    {
    }

    public function type(): Type
    {
        return $this->type;
    }

    public function id(): int
    {
        return $this->id;
    }
}