<?php

use yii\db\Migration;

/**
 * Class m241027_130318_add_table_product_table_settings
 */
class m241027_130318_add_table_product_table_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('properties_settings', [
            'id'=>$this->primaryKey(),
            'property_id'=>$this->integer(),
            'setting_type_id'=>$this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('properties_settings');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241027_130318_add_table_product_table_settings cannot be reverted.\n";

        return false;
    }
    */
}
