<?php

namespace app\modules\Product\application\ParsingSchema;
use app\forms\RelationPairForm;
use app\modules\Product\domain\ParsingSchema\Models\RelationshipPair;
use app\modules\Product\domain\ParsingSchema\ParsingSchema;
use app\modules\Product\infrastructure\repositories\PrasingSchema\ParsingSchemaRepository;

class ParsingSchemaService
{
    public function __construct(
        private ParsingSchemaRepository $repository = new ParsingSchemaRepository()
    )
    {
    }

    /**
     * @param string $categoryId
     * @param string $name
     * @param int $startFromRow
     * @param RelationPairForm[] $relationshipPairsForms
     * @return void
     */
    public function create(string $name, int $startFromRow, array $relationshipPairsForms): void
    {
        $schema = new ParsingSchema(
            $name,
            $startFromRow
        );
        foreach ($relationshipPairsForms as $form){
            $schema->add(
                new RelationshipPair(
                    $form->productProperty->id,
                    $form->externalFieldName,
                )
            );
        }
        $this->repository->save($schema);
    }

    /**
     * @param int $id
     * @param string $name
     * @param int $startFromRow
     * @param RelationPairForm[] $relationshipPairsForms
     * @return void
     * @throws \Throwable
     */
    public function update(
        int $id,
        string $name,
        int $startFromRow,
        array $relationshipPairsForms
    ): void
    {
        $schema = $this->repository->findById($id);
        $schema->rename($name);
        $schema->changeStartingRowNum($startFromRow);
        foreach ($relationshipPairsForms as $relationshipPairsForm){
            $schema->changeRelationPairLink(
                $relationshipPairsForm->id,
                $relationshipPairsForm->externalFieldName,
                $relationshipPairsForm->productProperty->id
            );
        }
        $this->repository->save($schema);
        $dd = 0;
    }
}