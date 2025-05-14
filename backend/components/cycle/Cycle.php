<?php

namespace app\components\cycle;

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\Config\Postgres\DsnConnectionConfig;
use Cycle\Database\Config\PostgresDriverConfig;
use Cycle\Database\DatabaseManager;
use Cycle\ORM\Collection\DoctrineCollectionFactory;
use Cycle\ORM\Factory;
use Cycle\ORM\ORM;
use Cycle\ORM\Schema;
use Yii;
use yii\base\Component;

class Cycle extends Component
{
    private $factory;
    public $options;

    public function init()
    {
        parent::init();
        $this->factory = new Factory(
            $this->dbal(),
            defaultCollectionFactory: new DoctrineCollectionFactory()
        );
    }

    public function orm(Schema $schema): ORM
    {
        return new ORM(
            $this->factory,
            $schema,
        );
    }

    private function dbal(): DatabaseManager
    {
        return new DatabaseManager(
            new DatabaseConfig([
                'default' => 'default',
                'databases' => [
                    'default' => ['connection' => 'postgres']
                ],
                'connections' => [
                    'postgres' => new PostgresDriverConfig(
                        new DsnConnectionConfig(
                            Yii::$app->db->dsn,
                            Yii::$app->db->username,
                            Yii::$app->db->password,
                        )
                    )
                ]
            ])

        );
    }
}