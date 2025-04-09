<?php

use yii\db\Migration;

class m250330_130827_add_product_template extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_templates', [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull()
            ]
        );
        $this->addColumn('properties', 'product_template_id', $this->integer()->notNull());

        $this->db->createCommand("INSERT INTO product_templates (name) VALUES ('Шаблон');")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('properties', 'product_template_id');
        $this->dropTable('product_templates');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250330_130827_add_product_template cannot be reverted.\n";

        return false;
    }
    */
}
