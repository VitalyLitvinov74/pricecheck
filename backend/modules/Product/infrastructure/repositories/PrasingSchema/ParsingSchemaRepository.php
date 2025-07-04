<?php

namespace app\modules\Product\infrastructure\repositories\PrasingSchema;

use app\collections\ParsingSchemas;
use app\collections\ProductPropertyCollection;
use app\libs\ObjectMapper\ObjectMapper;
use app\libs\UpsertBuilder;
use app\modules\Product\domain\ParsingSchema\ParsingSchema;
use app\modules\Product\domain\ParsingSchema\Persistence\Snapshots\SchemaSnapshot;
use app\records\pg\ParsingSchemaPropertiesRecord;
use app\records\pg\ParsingSchemaRecord;
use Yii;
use yii\db\Exception;

class ParsingSchemaRepository
{
    public function __construct(
        private ObjectMapper  $objectMapper = new ObjectMapper(),
        private UpsertBuilder $upsertBuilder = new UpsertBuilder()
    )
    {
    }

    public function findById(int $id): ParsingSchema
    {
        $schemaRecord = ParsingSchemaRecord::find()
            ->where([
                'id' => $id
            ])
            ->with([
                'parsingSchemaProperties'
            ])
            ->asArray()
            ->one();
        if ($schemaRecord === null) {
            throw new Exception(sprintf('Схема парсинга с id=%s не найдена', $id));
        }
        return $this->objectMapper->map($schemaRecord, ParsingSchema::class);
    }

    public function save(ParsingSchema $schema): void
    {
        $snapshot = $this->objectMapper->map($schema, SchemaSnapshot::class);
        $trx = Yii::$app->db->beginTransaction();
        try {
            $insertData = [
                'id' => $snapshot->id,
                'name' => $snapshot->name,
                'start_with_row_num' => $snapshot->startWithRowNum,
            ];
            $this->upsertBuilder
                ->useUniqueKeys([
                    'id'
                ])
                ->useActiveRecord(ParsingSchemaRecord::class)
                ->upsertManyRecords([$insertData]);
            $schemaId = $snapshot->id;
            if($schemaId === null){
                $schemaId = ParsingSchemaRecord::getDb()->getLastInsertID();
            }
            foreach ($snapshot->relationshipPairsSnapshots as $relationshipPairsSnapshot) {
                $pairs[] = [
                    'id' => $relationshipPairsSnapshot->id,
                    'schema_id' => $schemaId,
                    'property_id' => $relationshipPairsSnapshot->propertyId,
                    'external_column_name' => $relationshipPairsSnapshot->externalColumnName
                ];
            }
            $this->upsertBuilder
                ->useUniqueKeys([
                    'id'
                ])
                ->useActiveRecord(ParsingSchemaPropertiesRecord::class)
                ->upsertManyRecords($pairs);
            $trx->commit();
        } catch (\Throwable $exception) {
            $trx->rollBack();
            throw $exception;
        }
    }
}