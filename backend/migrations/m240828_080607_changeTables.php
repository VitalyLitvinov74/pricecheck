<?php

namespace app\migrations;

use app\domain\Type;
use yii\db\Migration;

/**
 * Class m240828_080607_changeTables
 */
class m240828_080607_changeTables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('categories');
        $this->createTable('properties', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
        ]);
        $this->execute(
            sprintf(
                "CREATE TYPE propertyType AS ENUM ('%s', '%s', '%s', '%s')",
                Type::Int->value,
                Type::String->value,
                Type::Decimal->value,
                Type::Float->value,
            )
        );
        $this->addColumn('properties', 'type', 'propertyType not null');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('properties');
        $this->execute('DROP TYPE propertyType');
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'fields' => $this->json(),
        ]);
        $this->createIndex('categories_title', 'categories', 'title', true);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240828_080607_changeTables cannot be reverted.\n";

        return false;
    }
    */
}
