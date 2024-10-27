<?php

namespace app\records;

use yii\db\ActiveRecord;

class CrmProductListSettingsRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'crm_product_list_settings';
    }
}