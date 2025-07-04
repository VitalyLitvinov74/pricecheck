<?php

use yii\db\Migration;

class m250315_090903_add_table_setting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropPrimaryKey('PRIMARY', 'properties_settings');
        $this->addColumn('properties_settings', 'user_id', $this->integer()->notNull());
        $this->addPrimaryKey('PRIMARY', 'properties_settings', ['user_id', 'property_id', 'setting_type_id']);
        $this->addColumn('properties_settings', 'value', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('properties_settings', 'value');
        $this->dropPrimaryKey('PRIMARY', 'properties_settings');
        $this->dropColumn('properties_settings', 'user_id');
        $this->addPrimaryKey('PRIMARY', 'properties_settings', ['property_id', 'setting_type_id']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250315_090903_add_table_setting_table cannot be reverted.\n";

        return false;
    }
    */
}
