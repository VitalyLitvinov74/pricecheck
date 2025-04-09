<?php

use yii\db\Migration;

class m250401_021630_add_new_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('admin_panel_settings', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
        ]);
        $this->execute('
            insert into admin_panel_settings (user_id, type) values (1, 1);
        ');
        $this->renameTable('products_list_settings', 'admin_panel_product_list_settings');
        $this->addColumn('admin_panel_product_list_settings', 'admin_panel_setting_id', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('admin_panel_product_list_settings', 'admin_panel_setting_id');
        $this->renameTable('admin_panel_product_list_settings', 'products_list_settings');
        $this->dropTable('admin_panel_settings');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250401_021630_add_new_table cannot be reverted.\n";

        return false;
    }
    */
}
