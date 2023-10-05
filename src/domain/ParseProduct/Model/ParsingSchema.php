<?php

namespace app\domain\ParseProduct\Model;

class ParsingSchema
{
    private string $id;

    public function __construct()
    {
        $this->id = uniqid();
    }

    public function hasId(string $id): bool
    {
        return $this->id === $id;
    }
}