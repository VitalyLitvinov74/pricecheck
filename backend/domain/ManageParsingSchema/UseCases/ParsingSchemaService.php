<?php

namespace app\domain\ManageParsingSchema\UseCases;
use app\domain\ManageParsingSchema\Models\RelationshipPair;
use app\domain\ManageParsingSchema\ParsingSchema;
use app\domain\ManageParsingSchema\Persistence\ParsingSchemaRepository;
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
            $schema->addRelationPair(
                $form->productPropertyName,
                $form->externalFieldName,
            );
        }
        $this->repository->push($schema, $categoryId);
    }

    /**
     * @param string $categoryID
     * @param string $name
     * @param int $startFromRow
     * @param RelationPairForm[] $relationshipPairsForms
     * @return void
     */
    public function update(string $categoryID, string $name, int $startFromRow, array $relationshipPairsForms): void
    {
        $schema = $this->repository->findByNameAndCategoryId($name, $categoryID);
        $schema->rename($name);
        $schema->changeStartingRowNum($startFromRow);
        foreach ($relationshipPairsForms as $relationshipPairsForm){
            $schema->changeRelationPairLink(
                $relationshipPairsForm->oldName,
                $relationshipPairsForm->productPropertyName,
                $relationshipPairsForm->externalFieldName
            );
        }
        $this->repository->update($schema, $categoryID);
    }
}