<?php

use yii\db\Migration;

/**
 * Class m240828_234534_addCollumn
 */
class m240828_234534_addCollumn extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('products', 'created_at', $this->timestamp()->defaultValue('now()'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('products', 'created_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240828_234534_addCollumn cannot be reverted.\n";

        return false;
    }
    */
}
