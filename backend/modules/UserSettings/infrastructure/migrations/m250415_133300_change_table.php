<?php
namespace app\modules\UserSettings\infrastructure\migrations;

use yii\db\Migration;

class m250415_133300_change_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_property_user_setting', [
            'id' => $this->primaryKey(),
            'product_property_id' => $this->integer(),
            'user_setting_id' => $this->integer()
        ]);
        $this->dropColumn('user_settings', 'entity_id');
        $this->dropColumn('user_settings', 'entity_type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('user_settings', 'entity_id', $this->integer());
        $this->addColumn('user_settings', 'entity_type', $this->integer());
        $this->dropTable('product_property_user_setting');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250415_133300_change_table cannot be reverted.\n";

        return false;
    }
    */
}
