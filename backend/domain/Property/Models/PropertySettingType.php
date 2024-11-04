<?php

namespace app\domain\Property\Models;

enum PropertySettingType: int
{
    case OnInProductListCRM = 1;
    case OffInProductListCRM = 0;
}