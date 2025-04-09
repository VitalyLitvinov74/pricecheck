<?php

use yii\db\Migration;

class m250330_193653_add_list_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('properties_settings');
        $this->createTable('products_list_settings', [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->notNull(),
            'value' => $this->integer(),
            'property_id' => $this->integer()->notNull()
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('products_list_settings');
        $this->db->createCommand('
            create table properties_settings
                (
                    property_id     integer not null,
                    setting_type_id integer not null,
                    value           integer,
                    id              integer not null
                        constraint "PRIMARY"
                            primary key
                        unique
                )
        ')->execute();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250330_193653_add_list_settings cannot be reverted.\n";

        return false;
    }
    */
}
