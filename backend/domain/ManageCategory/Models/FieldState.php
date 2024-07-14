<?php

namespace app\domain\ManageCategory\Models;

enum FieldState: string
{
    case On = "Включено";
    case Off = "Выключено";
}