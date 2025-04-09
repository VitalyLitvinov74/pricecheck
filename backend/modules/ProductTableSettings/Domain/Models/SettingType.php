<?php

namespace app\modules\ProductTableSettings\Domain\Models;

enum SettingType: int
{
    case ColumnNumber = 1;
    case IsEnabled = 2;
}