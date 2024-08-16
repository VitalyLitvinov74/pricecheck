<?php

use yii\db\Migration;

/**
 * Class m240816_154623_add_table
 */
class m240816_154623_add_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('categories', 'fields');
        $sql = "CREATE TYPE OnOff AS ENUM ('Включено', 'Выключено')";
        $this->execute($sql);
        $this->createTable('category_fields', [
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string(50)->notNull(),
            'type' => $this->string(20)->notNull(),
            'state' =>  'OnOff',
        ]);
        $sql = "ALTER TABLE category_fields ALTER state SET DEFAULT 'Включено'";
        $this->execute($sql);
        $this->addPrimaryKey('pk', 'category_fields', [
            'category_id', 'name'
        ]);
        $this->addForeignKey(
            "FK_category_fields_categories",
            'category_fields',
            'category_id',
            'categories',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_category_fields_categories', 'category_fields');
        $this->dropTable('category_fields');
        $this->execute('DROP TYPE OnOff');
        $this->addColumn('categories', 'fields', $this->json());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240816_154623_add_table cannot be reverted.\n";

        return false;
    }
    */
}
