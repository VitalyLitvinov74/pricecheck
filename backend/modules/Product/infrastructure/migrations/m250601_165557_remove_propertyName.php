<?php

namespace app\modules\Product\infrastructure\migrations;

use yii\db\Migration;

class m250601_165557_remove_propertyName extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('product_attributes', 'property_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('product_attributes', 'property_name', $this->string(100));
    }
}
