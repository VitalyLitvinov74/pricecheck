<?php

namespace app\domain\ProductListSettings\Models;

enum SettingType: int
{
    case ColumnNumber = 1;
    case IsEnabled = 2;
}