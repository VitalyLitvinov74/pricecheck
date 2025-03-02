<?php

namespace app\infrastructure\libs\ObjectMapper\Mapping\MappingModes;

enum MappingMode
{
    case arrayToModel;
    case objectToModel;
    case modelToArray;
    case modelToObject;
}
