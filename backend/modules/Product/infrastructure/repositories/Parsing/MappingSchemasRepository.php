<?php

namespace app\modules\Product\infrastructure\repositories\Parsing;

use app\components\cycle\Cycle;
use app\modules\Product\domain\Parsing\Models\MappingSchema;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;

class MappingSchemasRepository
{
    use MappingSchemaTrait;

    private ORM $ORM;
    private EntityManager $entityManager;

    public function __construct(private Cycle $cycle)
    {
        $this->ORM = $this->cycle->orm($this->schema());
        $this->entityManager = new EntityManager($this->ORM);
    }

    public function findBy(string $parsingSchemaId): MappingSchema
    {
        return $this->ORM
            ->getRepository(MappingSchema::class)
            ->findOne(['id', $parsingSchemaId]);
    }
}