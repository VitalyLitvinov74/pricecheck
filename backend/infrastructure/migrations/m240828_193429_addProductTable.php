<?php

namespace app\infrastructure\migrations;

use yii\db\Migration;

/**
 * Class m240828_193429_addProductTable
 */
class m240828_193429_addProductTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('products', [
            'id' => $this->primaryKey()
        ]);
        $this->createIndex('ind1', 'properties', ['id', 'name'], true);
        $this->createTable('product_attributes', [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer()->notNull(),
            'property_name' => $this->string(10)->notNull(),
            'value' => $this->string()->notNull(),
            'product_id' => $this->integer()
        ]);
        $this->addForeignKey(
            'fk_product_attributes_properties',
            'product_attributes',
            ['property_id', 'property_name'],
            'properties',
            ['id', 'name'],
            null,
            'cascade'
        );
        $this->addForeignKey(
            'fk_product_attributes_products',
            'product_attributes',
            'product_id',
            'products',
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
        $this->dropForeignKey('fk_product_attributes_products', 'product_attributes');
        $this->dropForeignKey('fk_product_attributes_properties', 'product_attributes');
        $this->dropTable('product_attributes');
        $this->dropIndex('ind1', 'properties');
        $this->dropTable('products');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240828_193429_addProductTable cannot be reverted.\n";

        return false;
    }
    */
}
