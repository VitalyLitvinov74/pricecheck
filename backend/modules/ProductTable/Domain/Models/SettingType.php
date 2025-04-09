<?php

namespace app\modules\ProductTable\Domain\Models;

enum SettingType: int
{
    case ColumnNumber = 1;
    case IsEnabled = 2;
}