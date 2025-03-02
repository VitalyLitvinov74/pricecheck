<?php

namespace app\infrastructure\migrations;

use yii\db\Migration;

/**
 * Class m240901_230513_change_string_length
 */
class m240901_230513_change_string_length extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('product_attributes', 'property_name', $this->string(100));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('product_attributes', 'property_name', $this->string(10));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240901_230513_change_string_length cannot be reverted.\n";

        return false;
    }
    */
}
