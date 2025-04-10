<?php

namespace app\modules\TableSettings\Domain\Models;

enum SettingType: int
{
    case ColumnNumber = 1;
    case IsEnabled = 2;
}