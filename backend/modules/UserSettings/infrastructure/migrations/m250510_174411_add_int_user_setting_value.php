<?php
namespace app\modules\UserSettings\infrastructure\migrations;

use yii\db\Migration;

class m250510_174411_add_int_user_setting_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('product_property_user_setting');
        $this->addColumn('user_settings', 'entity_id', $this->integer()->notNull());
        $this->addColumn('user_settings', 'entity_type', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_settings', 'entity_id');
        $this->dropColumn('user_settings', 'entity_type');
        $this->execute('
            create table public.product_property_user_setting
                (
                    id                  serial
                        primary key,
                    product_property_id integer,
                    user_setting_id     integer
                );
        ');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250510_174411_add_int_user_setting_value cannot be reverted.\n";

        return false;
    }
    */
}
