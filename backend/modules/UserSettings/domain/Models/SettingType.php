<?php

namespace app\modules\UserSettings\domain\Models;

enum SettingType: int
{
    case ColumnNumber = 1;
    case IsEnabled = 2;
}