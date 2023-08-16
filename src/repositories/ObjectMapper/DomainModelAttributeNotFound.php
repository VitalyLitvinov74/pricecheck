<?php

namespace app\modules\pbx\repositories\ObjectMapper;

use app\modules\pbx\repositories\ObjectMapper\Attributes\DomainModel;

class DomainModelAttributeNotFound extends \Exception
{
    public function __construct(string $objectClass)
    {
        parent::__construct("Ваш объект " . $objectClass . " не является " . DomainModel::class, 404, null);
    }
}