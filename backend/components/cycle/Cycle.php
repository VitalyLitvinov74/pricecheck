<?php

namespace app\components\cycle;

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\Config\MySQL\ConnectionConfig;
use Cycle\Database\Config\MySQL\DsnConnectionConfig;
use Cycle\Database\Config\MySQLDriverConfig;
use Cycle\Database\Config\PostgresDriverConfig;
use Cycle\Database\DatabaseManager;
use Cycle\Database\Driver\Postgres\PostgresDriver;
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
        $this->factory = new Factory($this->dbal());
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
                    'postgres'  => [
                        'driver'   => PostgresDriver::class,
                        'options' => [
                            'connection' => $this->dsn,
                            'username'   => $this->username,
                            'password'   => $this->password,
                        ],
                    ],
                ]
            ])
        );
    }
}