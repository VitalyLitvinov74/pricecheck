<?php

use yii\db\Migration;

/**
 * Class m240816_194717_add_parsingschemas_table
 */
class m240816_194717_add_parsingschemas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parsing_schemas', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'startWithRowNum' => $this->integer()->notNull()
        ]);
        $this->createTable('category_parsing_schemas', [
            'categoryId' => $this->integer()->notNull(),
            'schemaId' => $this->integer()->notNull()
        ]);
        $this->addPrimaryKey('PRIMARY', 'category_parsing_schemas', [
            'categoryId',
            'schemaId'
        ]);
        $this->addForeignKey(
            'fk_category_parsing_schemas_category_id',
            'category_parsing_schemas',
            'categoryId',
            'categories',
            'id',
            'cascade',
            'cascade'
        );
        $this->addForeignKey(
            'fk_category_parsing_schemas_schema_id',
            'category_parsing_schemas',
            'schemaId',
            'parsing_schemas',
            'id',
            'cascade',
            'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropForeignKey('fk_category_parsing_schemas_category_id', 'category_parsing_schemas');
       $this->dropForeignKey('fk_category_parsing_schemas_schema_id', 'category_parsing_schemas');
       $this->dropTable('category_parsing_schemas');
       $this->dropTable('parsing_schemas');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240816_194717_add_parsingschemas_table cannot be reverted.\n";

        return false;
    }
    */
}
