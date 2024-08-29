<?php

namespace app\domain\Product\Models;

class Property
{
    private string $name;
    private string $id;

    private function __construct()
    {
    }

    public function hasName(string $name): bool
    {
        return $this->name === $name;
    }
}