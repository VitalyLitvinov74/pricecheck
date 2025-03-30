<?php
namespace app\infrastructure\migrations;
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
        $this->createTable('product_template_properties', [
            'id' => $this->primaryKey(),
            'template_id' => $this->integer()->notNull(),
            'property_id' => $this->integer()->notNull()
        ]);
        $this->db->createCommand("INSERT INTO product_templates (name) VALUES ('Шаблон');")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product_template_properties');
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
