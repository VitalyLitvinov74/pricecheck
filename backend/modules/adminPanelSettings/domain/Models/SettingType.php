<?php

namespace app\modules\adminPanelSettings\domain\Models;

enum SettingType: int
{
    case ColumnNumber = 1;
    case IsEnabled = 2;
}