<?php

namespace app\domain\ManageCategories\Models;

enum FieldState: string
{
    case On = "Включено";
    case Off = "Выключено";
}