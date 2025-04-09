<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Class m241109_100810_add_keys
 */
class m241109_100810_add_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('unique', 'product_attributes', ['product_id', 'property_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('unique', 'product_attributes');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241109_100810_add_keys cannot be reverted.\n";

        return false;
    }
    */
}
