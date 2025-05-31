<?php

namespace app\modules\Product\infrastructure\repositories\Parsing;

use app\modules\Product\domain\Parsing\Models\MappingSchema;
use app\records\pg\ParsingSchemaRecord;
use yii\db\ActiveQuery;

class MappingSchemasRepository
{
    public function __construct()
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