<?php

namespace app\components\cycle;

use Cycle\Annotated\Embeddings;
use Cycle\Annotated\Entities;
use Cycle\Annotated\MergeColumns;
use Cycle\Annotated\MergeIndexes;
use Cycle\Annotated\TableInheritance;
use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\Config\MySQL\DsnConnectionConfig;
use Cycle\Database\Config\MySQLDriverConfig;
use Cycle\Database\Config\SQLite\MemoryConnectionConfig;
use Cycle\Database\Config\SQLiteDriverConfig;
use Cycle\Database\DatabaseManager;
use Cycle\ORM\EntityManager;
use Cycle\ORM\Factory;
use Cycle\ORM\ORM;
use Cycle\ORM\RepositoryInterface;
use Cycle\ORM\Schema;
use Cycle\Schema\Compiler;
use Cycle\Schema\Generator\GenerateModifiers;
use Cycle\Schema\Generator\GenerateRelations;
use Cycle\Schema\Generator\GenerateTypecast;
use Cycle\Schema\Generator\RenderModifiers;
use Cycle\Schema\Generator\RenderRelations;
use Cycle\Schema\Generator\RenderTables;
use Cycle\Schema\Generator\ResetTables;
use Cycle\Schema\Generator\SyncTables;
use Cycle\Schema\Generator\ValidateEntities;
use Cycle\Schema\Registry;
use Spiral\Tokenizer\Config\TokenizerConfig;
use Spiral\Tokenizer\Tokenizer;
use Yii;
use yii\base\Component;

class CycleComponent extends Component
{
    private ORM $orm;

    public function init(): void
    {
        $classLocator = (new Tokenizer(
            new TokenizerConfig([
                'directories' => [Yii::getAlias('@app/domain')],
            ])
        ))->classLocator();

        $dbal = new DatabaseManager(
            new DatabaseConfig([
                'default' => 'default',
                'databases' => [
                    'default' => ['connection' => 'db'],
                    'db2' => ['connection' => 'db2']
                ],
                'connections' => [
                    'db' => new MySQLDriverConfig(
                        new DsnConnectionConfig(
                            dsn: Yii::$app->db->dsn,
                            user: Yii::$app->db->username,
                            password: Yii::$app->db->password
                        )
                    ),
                    'db2' => new MySQLDriverConfig(
                        new DsnConnectionConfig(
                            dsn: Yii::$app->db2->dsn,
                            user: Yii::$app->db2->username,
                            password: Yii::$app->db2->password
                        )
                    )
                ]
            ])
        );
        $dbal->setLogger(new StdoutQueryLogger());

        $schema = (new Compiler())->compile(new Registry($dbal), [
            new ResetTables(),             // re-declared table schemas (remove columns)
            new Embeddings($classLocator),        // register embeddable entities
            new Entities($classLocator),          // register annotated entities
            new TableInheritance(),               // register STI/JTI
            new MergeColumns(),                   // add @Table column declarations
            new GenerateRelations(),       // generate entity relations
            new GenerateModifiers(),       // generate changes from schema modifiers
            new ValidateEntities(),        // make sure all entity schemas are correct
            new RenderTables(),            // declare table schemas
            new RenderRelations(),         // declare relation keys and indexes
            new RenderModifiers(),         // render all schema modifiers
            new MergeIndexes(),                   // add @Table column declarations
            new GenerateTypecast(),        // typecast non string columns
        ]);

        $this->orm = new ORM(new Factory($dbal), new Schema($schema));
        parent::init();
    }

    public function entityManager(): EntityManager
    {
        return new EntityManager($this->orm);
    }

    public function repository(string|object $entity): RepositoryInterface
    {
        return $this->orm->getRepository($entity);
    }
}