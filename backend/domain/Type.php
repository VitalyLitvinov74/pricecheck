<?php

namespace app\domain;

enum Type: string
{
    case String = "string";
    case Int = "int";
    case Decimal = "decimal";
    case Float = "float";
}