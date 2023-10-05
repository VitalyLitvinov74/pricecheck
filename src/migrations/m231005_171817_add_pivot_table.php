<?php

use yii\db\Migration;

/**
 * Class m231005_171817_add_pivot_table
 */
class m231005_171817_add_pivot_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_price_list', [
            'product_id'=>$this->integer(),
            'price_list_id'=>$this->integer()
        ]);
        $this->addPrimaryKey('PRIMARY', 'product_price_list', ['product_id', 'price_list_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product_price_list');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231005_171817_add_pivot_table cannot be reverted.\n";

        return false;
    }
    */
}
