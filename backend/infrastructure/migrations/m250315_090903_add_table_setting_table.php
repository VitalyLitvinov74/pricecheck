<?php
namespace app\infrastructure\migrations;
use yii\db\Migration;

class m250315_090903_add_table_setting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('products_table_settings', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'property_id' => $this->integer()->notNull(),
            'position' => $this->integer()->defaultValue(1)->notNull()
        ]);
        $this->addForeignKey(
            'FK_KJHASDHR',
            'products_table_settings',
            'property_id',
            'properties',
            'id',
            'SET NULL',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('products_table_settings');
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
