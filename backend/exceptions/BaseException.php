<?php

namespace app\exceptions;


use Exception;

class BaseException extends Exception
{
    public function __construct($message, $code = 500)
    {
        parent::__construct(
            $message,
            $code,
            $this
        );
    }
}