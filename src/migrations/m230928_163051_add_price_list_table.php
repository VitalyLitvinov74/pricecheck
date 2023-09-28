<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m230928_163051_add_price_list_table
 */
class m230928_163051_add_price_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'price_lists',
            [
                'id'=>$this->primaryKey(),
                'source' => $this->string(),
                'type'=> $this->tinyInteger(),
                'uploaded_at'=>$this->timestamp()
                    ->defaultValue(new Expression('NOW()'))
            ]
        );

        $this->createTable('products', [
            'id'=>$this->primaryKey(),
            'price_list_id'=>$this->integer(),
            'name'=>$this->string(),
            'price'=>$this->decimal(),
        ]);

        $this->createTable('document_parse_schemas', [
            'id'=>$this->primaryKey(),
            'name'=>$this->string(),
            'schema'=>$this->json()->comment('Схема парсинга документа')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('price_lists');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230928_163051_add_price_list_table cannot be reverted.\n";

        return false;
    }
    */
}
