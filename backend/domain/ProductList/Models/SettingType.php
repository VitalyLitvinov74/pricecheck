<?php

namespace app\domain\ProductList\Models;

enum SettingType: int
{
    case ColumnNumber = 1;
    case IsEnabled = 2;
}