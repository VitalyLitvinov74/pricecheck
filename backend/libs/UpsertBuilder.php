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
    private const mysql = 1;
    private const pg = 2;
    private Connection|null $db = null;

    private string|null $tableName = null;

    private array|null $dataForInsert = null;
    private array $uniqueKeys = ['id'];

    /**
     * @param string|ActiveRecord $activeRecord
     *
     * @return self
     */
    public function useActiveRecord(string|ActiveRecord $activeRecord): self
    {
        $this->db = $activeRecord::getDb();
        $this->tableName = $activeRecord::tableName();
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
        $baseInsertSql = $this->db->queryBuilder->batchInsert(
            $this->tableName,
            $this->columnNamesForInsert(),
            $this->dataForInsert()
        );
        $duplicateKeysExpression = $this->onUpdateDuplicateKeysExpression();
        $this->db->createCommand($baseInsertSql . $duplicateKeysExpression)->execute();
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
        $this->uniqueKeys = ['id'];
    }

    private function onUpdateDuplicateKeysExpression(): Expression
    {
        return match ($this->dbType()) {
            self::pg => $this->pgOnDuplicateKeyExpression(),
            self::mysql => $this->mysqlOnDuplicateKeyExpression()
        };
    }

    private function dbType(): int
    {
        if (preg_match('/(.+):/', $this->db->dsn, $match) && $match[1] == 'pgsql') {
            return self::pg;
        }
        return self::mysql;
    }

    public function useUniqueKeys(array $pk): self
    {
        $this->uniqueKeys = $pk;
        return $this;
    }

    private function mysqlOnDuplicateKeyExpression(): Expression
    {
        $columnNames = $this->columnNamesForInsert();
        $result = '';
        foreach ($columnNames as $key => $columnName) {
            $result .= "$columnName=values($columnName)";
            if ($key !== array_key_last($columnNames)) {
                $result .= ',';
            }
        }
        return new Expression(' ON DUPLICATE KEY UPDATE ' . $result);
    }

    private function pgOnDuplicateKeyExpression(): Expression
    {
        $result = '';
        $columnNames = $this->uniqueKeys;
        foreach ($columnNames as $key => $columnName) {
            $result .= sprintf(
                '%s = excluded.%s',
                $columnName,
                $columnName
            );
            if ($key !== array_key_last($columnNames)) {
                $result .= ', ';
            }
        }
        return new Expression(sprintf(
            " ON CONFLICT (%s) DO UPDATE SET %s",
            implode(',', $columnNames),
            $result
        ));
    }

    private function dataForInsert(): array
    {
        $data = $this->dataForInsert;
        if($this->dbType() === self::pg){
            foreach ($data as $rowNum => $row){
                foreach ($row as $columnName => $column){
                    if($column !== null){
                        continue;
                    }
                    $data[$rowNum][$columnName] = new Expression('default');
                }
            }
            return $data;
        }

        return $data;
    }
}