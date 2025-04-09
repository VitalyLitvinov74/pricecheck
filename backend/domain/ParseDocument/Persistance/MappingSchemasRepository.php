<?php

namespace app\domain\ParseDocument\Persistance;

use app\domain\ParseDocument\Models\MappingSchema;
use app\infrastructure\records\pg\ParsingSchemaRecord;
use app\libs\ObjectMapper\ObjectMapper;
use yii\db\ActiveQuery;

class MappingSchemasRepository
{
    public function __construct(private ObjectMapper $objectMapper = new ObjectMapper())
    {
    }

    public function findBy(string $parsingSchemaId): MappingSchema
    {
        $data = ParsingSchemaRecord::find()
            ->where(['id'=>$parsingSchemaId])
            ->with([
                'parsingSchemaProperties'=>function(ActiveQuery $query){
                    $query
                        ->alias('psp')
                        ->select([
                            'psp.external_column_name',
                            'psp.property_id',
                            'psp.id',
                            'psp.schema_id',
                            'type'=>'p.type'
                        ])
                        ->leftJoin('properties p', 'p.id = psp.property_id');
                }
            ])
            ->asArray()
            ->one();
        return $this->objectMapper->map($data, MappingSchema::class);
    }

    public function mapProductsToArrays(){}
}