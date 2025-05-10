<?php
namespace app\modules\UserSettings\infrastructure\migrations;

use yii\db\Migration;

class m250510_165943_add_int_user_setting_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_settings', 'int_value', $this->integer());
        $this->renameColumn('user_settings', 'value', 'string_value');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('user_settings', 'string_value', 'value');
        $this->dropColumn('user_settings', 'int_value',);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250510_165943_add_int_user_setting_value cannot be reverted.\n";

        return false;
    }
    */
}
