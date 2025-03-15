<?php

namespace app\modules\Property\Domain\Models;

enum PropertySettingType: int
{
    case EnabledProductListCRM = 1;
    case DisabledInProductListCRM = 0;

    case ColumnNum = 2;
    case BelongsToUser = 3;
}