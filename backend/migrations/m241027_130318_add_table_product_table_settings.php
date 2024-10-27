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
        $this->createTable('crm_product_list_settings', [
            'id'=>$this->primaryKey(),
            'table_settings_id'=>$this->integer(),
            'property_id'=>$this->integer(),
            'setting'=>$this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('crm_product_list_settings');
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
