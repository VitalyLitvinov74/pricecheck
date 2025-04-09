<?php

use yii\db\Migration;

/**
 * Class m240714_210654_addTables
 */
class m240714_210654_addTables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'fields' => $this->json(),
        ]);
        $this->createIndex('categories_title', 'categories', 'title', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('categories');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240714_210654_addTables cannot be reverted.\n";

        return false;
    }
    */
}
