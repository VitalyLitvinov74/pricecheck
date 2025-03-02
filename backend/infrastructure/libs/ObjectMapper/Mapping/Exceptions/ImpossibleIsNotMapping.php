<?php

namespace app\infrastructure\libs\ObjectMapper\Mapping\Exceptions;

use app\infrastructure\libs\LibsException;

class ImpossibleIsNotMapping extends LibsException
{
    public function __construct(string $reason)
    {
        parent::__construct($reason, 500);
    }
}