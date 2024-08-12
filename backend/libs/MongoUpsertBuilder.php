<?php

namespace app\libs;

use Yii;

class MongoUpsertBuilder
{
    private string $collectionName;
    private string $arName;

    /**
     * @param string $className
     * @return self
     */
    public function useActiveRecord(string $className): self
    {
        $this->collectionName = $className::collectionName();
        $this->arName = $className;
        return $this;
    }

    public function upsertOneRecord(array $data, array $where, array $primaryKeysForNestedCollections = []): void
    {
        $set = [];
        foreach ($data as $propertyName => $value) {
            $set[$propertyName] = $this->buildQueryForProperty(
                $propertyName,
                $value,
                $primaryKeysForNestedCollections
            );

        }
        Yii::$app->mongodb->createCommand()
            ->addUpdate(
                $where,
                ['$set' => [
                    'parsingSchemas' => json_encode($set, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)]
                ],
                ['upsert' => true]
            )
            ->executeBatch($this->collectionName);
    }

    public function upsertManyRecords(): void
    {
        //сделать на основе One
    }

    private function buildQueryForProperty($propertyName, $value, $primaryKeysForNestedCollections): array|string
    {
        if (is_array($value)) {
            $nestedPrimaryKey = $primaryKeysForNestedCollections[$propertyName] ?? "name";
            return $this->queryForNestedCollectionOfObjects(
                $value,
                $propertyName,
                $nestedPrimaryKey
            );
        }
        return $value;
    }

    /**
     * @param string $primaryKeyName - первичный ключ объекта, для его обновления или вставки нового объекта
     * @return array
     * за основу взят запрос:
     */
    private function queryForNestedCollectionOfObjects(
        array  $nestedCollectionOfObjects,
        string $titleOfCollection,
        string $primaryKeyName
    ): array
    {
        return [
            '$map' => [
                'input' => $nestedCollectionOfObjects,
                'as' => 'inputObject',
                'in' => [
                    '$cond' => [
                        'if' => [
                            '$in' => [
                                sprintf('$$inputObject.%s', $primaryKeyName),
                                sprintf('$%s.%s', $titleOfCollection, $primaryKeyName)]
                        ],
                        'then' => [
                            '$mergeObjects' => [
                                [
                                    '$arrayElemAt' => [
                                        sprintf('$%s', $titleOfCollection),
                                        [
                                            '$indexOfArray' => [
                                                sprintf('$%s', $titleOfCollection),
                                                [
                                                    'eq' => [
                                                        sprintf('$%s.%s', $titleOfCollection, $primaryKeyName)],
                                                    sprintf('$$inputObject.%s', $primaryKeyName)
                                                ]
                                            ]
                                        ]
                                    ]
                                ],
                                '$$inputObject'
                            ]
                        ],
                        'else' => '$$inputObject'
                    ]
                ]
            ]
        ];
    }
}