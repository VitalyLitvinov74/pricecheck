<?php

namespace app\domain\ProductTemplate\Models;

enum ValueType: string
{
    case String = "string";
    case Int = "int";
    case Decimal = "decimal";
    case Float = "float";
}