<?php

namespace app\domain\ParsingSchema\UseCases;
use app\domain\ParsingSchema\Models\RelationshipPair;
use app\domain\ParsingSchema\ParsingSchema;
use app\domain\ParsingSchema\Persistence\ParsingSchemaRepository;
use app\forms\RelationPairForm;

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
    public function create(string $categoryId, string $name, int $startFromRow, array $relationshipPairsForms): void
    {
        $schema = new ParsingSchema(
            $name,
            $startFromRow
        );
        foreach ($relationshipPairsForms as $form){
            $schema->add(
                new RelationshipPair(
                    $form->productPropertyName,
                    $form->externalFieldName,
                )
            );
        }
        $this->repository->push($schema, $categoryId);
    }

    /**
     * @param string $categoryId
     * @param string $name
     * @param int $startFromRow
     * @param RelationPairForm[] $relationshipPairsForms
     * @return void
     */
    public function update(string $categoryId, string $name, int $startFromRow, array $relationshipPairsForms): void
    {
        $schema = $this->repository->findByNameAndCategoryId($name, $categoryId);
        $schema->rename($name);
        $schema->changeStartingRowNum($startFromRow);
        $this->repository->update($schema, $categoryId);
    }
}