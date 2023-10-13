<?php

namespace app\modules\pbx\libs\ObjectMapper;

use Exception;

class DtoPropertyNotFound extends Exception
{
    public function __construct(string $dtoPropertyName, string $modelClassName, string $existedModelPropertyName)
    {
        $message = sprintf(
            "В DTO отсутствует свойство %s, которое указано в модели %s, в качестве аттрибута, для приватного свойства %s",
            $dtoPropertyName,
            $modelClassName,
            $existedModelPropertyName
        );
        parent::__construct($message, 500, null);
    }
}