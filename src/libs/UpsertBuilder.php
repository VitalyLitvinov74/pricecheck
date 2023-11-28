<?php

namespace app\libs;

use yii\db\ActiveRecord;
use yii\db\Connection;
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

    /**
     * @param string|ActiveRecord $activeRecord
     *
     * @return self
     */
    public function useActiveRecord(string|ActiveRecord $activeRecord): self
    {
        return $this->useDb($activeRecord::getDb())
            ->inTable($activeRecord::tableName());
    }

    public function inTable(string $tableName): self
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function useDb(Connection $db): self
    {
        $this->db = $db;
        return $this;
    }

    /**
     * @param array $data
     *
     * @return void
     * @throws LibsException
     */
    public function upsertOneRecord(array $data): void
    {
        $this->upsertManyRecords([$data]);
    }

    /**
     * @param array $data
     *
     * @return void
     * @throws LibsException
     */
    public function upsertManyRecords(array $data): void
    {
        if ($data === []) {
            $this->dataForInsert = [];
            $this->execute();
            return;
        }
        $firstKey = array_key_first($data);
        if (is_array($data[$firstKey]) === false) {
            throw new LibsException('upsertManyRecords используется для обновления только одной записи, а не всех');
        }
        $this->dataForInsert = $data;
        $this->execute();
    }

    private function execute(): void
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

    private function columnNamesForInsert(): array
    {
        if ($this->dataForInsert === []) {
            return [];
        }
        $firstKey = array_key_first($this->dataForInsert);
        return array_keys($this->dataForInsert[$firstKey]);
    }

    private function clean(): void
    {
        $this->db = null;
        $this->dataForInsert = null;
        $this->tableName = null;
        $this->onDuplicateKeysExpression = null;
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