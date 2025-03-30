<?php

namespace app\infrastructure\cycle;

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\Config\Postgres\TcpConnectionConfig;
use Cycle\Database\Config\PostgresDriverConfig;
use Cycle\Database\DatabaseManager;
use Cycle\ORM\Collection\DoctrineCollectionFactory;
use Cycle\ORM\EntityManager;
use Cycle\ORM\Factory;
use Cycle\ORM\ORM;
use Cycle\ORM\Schema;
use yii\base\Component;

class Cycle extends Component
{
    private $factory;
    public $dsn;
    public $username;
    public $password;
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
            $schema
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
                    'postgres'  => new PostgresDriverConfig(
                        new TcpConnectionConfig(
                            'pricecheck',
                            'postgres',
                            5432,
                            $this->username,
                            $this->password
                        )
                    )
                ]
            ])

        );
    }
}