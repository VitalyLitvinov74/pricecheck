<?php

namespace app\modules\TableSettings\infrastructure\migrations;

use yii\db\Migration;

class m250410_174526_rename_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('admin_panel_product_list_settings', 'admin_panel_columns_settings');
        $this->renameColumn(
            'admin_panel_columns_settings',
            'property_id',
            'property_of_business_logic_entity_id',
        );
        $this->renameColumn('admin_panel_columns_settings', 'type', 'column_setting_type');
        $this->renameTable('admin_panel_settings', 'admin_panel_entities');
        $this->renameColumn('admin_panel_columns_settings', 'admin_panel_setting_id', 'admin_panel_entity_id');
        $this->addColumn('admin_panel_columns_settings', 'business_logic_entity_type', $this->integer()->notNull()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('admin_panel_columns_settings', 'business_logic_entity_type');
        $this->renameColumn('admin_panel_columns_settings', 'admin_panel_entity_id', 'admin_panel_setting_id');
        $this->renameTable('admin_panel_entities', 'admin_panel_settings');
        $this->renameColumn('admin_panel_columns_settings', 'column_setting_type', 'type');
        $this->renameColumn('admin_panel_columns_settings', 'property_of_business_logic_entity_id', 'property_id');
        $this->renameTable('admin_panel_columns_settings', 'admin_panel_product_list_settings');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250410_174526_rename_table cannot be reverted.\n";

        return false;
    }
    */
}
