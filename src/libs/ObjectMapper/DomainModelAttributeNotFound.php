<?php

namespace app\modules\pbx\libs\ObjectMapper;

use app\modules\pbx\libs\ObjectMapper\Attributes\DomainModel;
use Exception;

class DomainModelAttributeNotFound extends Exception
{
    public function __construct(string $objectClass)
    {
        parent::__construct("Ваш объект " . $objectClass . " не является " . DomainModel::class, 404, null);
    }
}