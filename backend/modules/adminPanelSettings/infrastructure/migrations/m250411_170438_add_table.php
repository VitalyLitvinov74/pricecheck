<?php

namespace app\modules\adminPanelSettings\infrastructure\migrations;

use yii\db\Migration;

class m250411_170438_add_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('admin_panel_entities');
        $this->createTable('admin_panel_settings', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->defaultValue(1),
            'type' => $this->integer()->notNull(),
            'params' => $this->json()
        ]);
        $this->dropTable('admin_panel_columns_settings');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("
            create table admin_panel_columns_settings
            (
                id                                     integer default nextval('products_list_settings_id_seq'::regclass) not null
                    constraint products_list_settings_pkey
                        primary key,
                column_setting_type                    integer                                                            not null,
                value                                  integer,
                property_of_business_logic_entity_id   integer                                                            not null,
                admin_panel_entity_id                  integer                                                            not null,
                property_type_of_business_logic_entity integer default 1                                                  not null
            );
        ");
        $this->dropTable('admin_panel_settings');
        $this->execute("
            create table admin_panel_entities
            (
                id      integer default nextval('admin_panel_settings_id_seq'::regclass) not null
                    constraint admin_panel_settings_pkey
                        primary key,
                user_id integer                                                          not null,
                type    integer                                                          not null
            )
        ");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250411_170438_add_table cannot be reverted.\n";

        return false;
    }
    */
}
