<?php

namespace app\infrastructure\migrations\elastic;

use Yii;
use yii\db\Migration;

class m250309_153547_add_elastic_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $db = Yii::$app->elasticsearch;
        $db->createCommand()->createIndex(
            'products',
            [
                "mappings" => [
                    "properties" => [
                        'property_id' => ['type' => 'integer'],
                        'attribute_value' => ['type' => 'text'],
                        'product_id' => ['type' => 'integer']
                    ]
                ]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $db = Yii::$app->elasticsearch;
        $db->createCommand()->deleteIndex('products');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250309_153547_add_elastic_index cannot be reverted.\n";

        return false;
    }
    */
}
