<?php

namespace app\libs\ObjectMapper\Mapping\Exceptions;

use app\libs\LibsException;

class ImpossibleIsNotMapping extends LibsException
{
    public function __construct(string $reason)
    {
        parent::__construct($reason, 500);
    }
}