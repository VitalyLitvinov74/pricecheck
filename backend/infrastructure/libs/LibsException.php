<?php

namespace app\infrastructure\libs;

use yii\db\Exception;

class LibsException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message, [], 500, $this);
    }
}