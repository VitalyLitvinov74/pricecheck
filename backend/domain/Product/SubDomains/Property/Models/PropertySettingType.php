<?php

namespace app\domain\Product\SubDomains\Property\Models;

enum PropertySettingType: int
{
    case EnabledProductListCRM = 1;
    case ColumnNum = 2;
}