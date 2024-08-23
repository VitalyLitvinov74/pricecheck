<?php

namespace app\domain\ProductProperty\Models;

enum Type: string
{
    case String = "string";
    case Int = "int";
    case Decimal = "decimal";
    case Float = "float";
}