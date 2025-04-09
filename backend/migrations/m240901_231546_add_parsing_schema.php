<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Class m240901_231546_add_parsing_schema
 */
class m240901_231546_add_parsing_schema extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parsing_schemas', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'start_with_row_num' => $this->bigInteger()->notNull()->defaultValue(1),
        ]);
        $this->createTable('parsing_schema_properties', [
            'id' => $this->primaryKey(),
            'schema_id' => $this->integer()->notNull(),
            'property_id' => $this->integer()->notNull(),
            'external_column_name' => $this->string()->notNull()
        ]);
        $this->addForeignKey(
            'parsing_schemas-parsing_schema_properties-fk',
            'parsing_schema_properties',
            'schema_id',
            'parsing_schemas',
            'id',
            'cascade',
            'cascade'
        );

        $this->addForeignKey(
            'properties-parsing_schema_properties-fk',
            'parsing_schema_properties',
            'property_id',
            'properties',
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
        $this->dropTable('parsing_schema_properties');
        $this->dropTable('parsing_schemas');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240901_231546_add_parsing_schema cannot be reverted.\n";

        return false;
    }
    */
}
