<?php

namespace app\modules\pbx\libs;

use yii\db\Connection;
use yii\db\Exception;
use yii\db\Expression;

/**
 * Билдер который помогает быстро построить запрос upsert для одной или нескольких записей.
 * см. функцию upsert (во фреймворке yii2).
 */
class UpsertBuilder
{
    private Connection|null $db = null;

    private string|null $tableName = null;

    private Expression|null $onDuplicateKeysExpression = null;

    private array|null $dataForInsert = null;

    public function useDb(Connection $db): self
    {
        $this->db = $db;
        return $this;
    }

    public function inTable(string $tableName): self
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function useActiveRecord(string $activeRecord): self
    {
        return $this->useDb($activeRecord::getDb())
            ->inTable($activeRecord::tableName());
    }

    public function upsertOneRecord(array $data): self
    {
        return $this->upsertManyRecords([$data]);
    }

    public function upsertManyRecords(array $data): self
    {
        if ($data === []) {
            $this->dataForInsert = [];
            return $this;
        }
        $firstKey = array_key_first($data);
        if (is_array($data[$firstKey]) === false) {
            throw new Exception('upsertManyRecords используется для обновления только одной записи, а не всех');
        }
        $this->dataForInsert = $data;
        return $this;
    }

    public function execute(): void
    {
        if ($this->columnNamesForInsert() === []) {
            $this->clean();
            return;
        }
        $batchInsertSql = $this->db->queryBuilder->batchInsert(
            $this->tableName,
            $this->columnNamesForInsert(),
            $this->dataForInsert
        );
        if (is_null($this->onDuplicateKeysExpression)) {
            $this->onUpdateDuplicateKey(
                $this->columnNamesForInsert()
            );
        }
        $this->db->createCommand($batchInsertSql . $this->onDuplicateKeysExpression)->execute();
        $this->clean();
    }

    private function clean(): void
    {
        $this->db = null;
        $this->dataForInsert = null;
        $this->tableName = null;
        $this->onDuplicateKeysExpression = null;
    }

    private function columnNamesForInsert(): array
    {
        if($this->dataForInsert === []){
            return [];
        }
        $firstKey = array_key_first($this->dataForInsert);
        return array_keys($this->dataForInsert[$firstKey]);
    }

    public function onUpdateDuplicateKey(array $duplicateKeys): self
    {
        $sqlString = '';
        foreach ($duplicateKeys as $key => $columnName) {
            $sqlString .= "$columnName=values($columnName)";
            if ($key !== array_key_last($duplicateKeys)) {
                $sqlString .= ',';
            }
        }
        $this->onDuplicateKeysExpression = new Expression(' ON DUPLICATE KEY UPDATE ' . $sqlString);
        return $this;
    }
}