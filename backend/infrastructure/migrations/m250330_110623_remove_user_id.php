<?php
namespace app\infrastructure\migrations;
use yii\db\Migration;

class m250330_110623_remove_user_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('properties_settings','id', $this->integer()->notNull()->unique());
        $this->dropColumn('properties_settings','user_id',);
        $this->addPrimaryKey('PRIMARY', 'properties_settings', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('properties_settings','user_id', $this->integer()->notNull());
        $this->dropColumn('properties_settings','id',);
        $this->addPrimaryKey('PRIMARY', 'properties_settings', ['user_id', 'property_id', 'setting_type_id']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250330_110623_remove_user_id cannot be reverted.\n";

        return false;
    }
    */
}
