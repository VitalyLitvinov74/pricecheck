<?php

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
        $this->renameTable('categories', 'properties');
        $this->renameColumn('properties', 'title', 'name');
        $this->dropColumn('properties', 'fields');
        $this->execute(
            sprintf(
                "CREATE TYPE propertyType AS ENUM ('%s', '%s', '%s', '%s')",
                Type::Int->value,
                Type::String->value,
                Type::Decimal->value,
                Type::Float->value,
            )
        );
        $this->addColumn('properties', 'type', 'propertyType');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('properties', 'type');
        $this->renameColumn('properties', 'name', 'title');
        $this->addColumn('properties', 'fields', $this->json());
        $this->renameTable('properties', 'categories');
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
