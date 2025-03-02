<?php

namespace app\infrastructure\libs;

/**
 * Поддерживает хеширование ключей в виде массивов
 */
class IdentityMap
{
    private array $map = [];


    /**
     * @param object|array|string $entityKey
     *
     * @return object|null
     */
    public function relationOf(object|array|string $entityKey): object|null
    {
        if ($this->has($entityKey)) {
            return $this->map[$this->computeHash($entityKey)];
        }
        return null;
    }

    public function has(object|array|string $entityKey): bool
    {
        $hash = $this->computeHash($entityKey);
        return array_key_exists($hash, $this->map);
    }

    private function computeHash(array|object|string $entity): string
    {
        return match (true) {
            is_object($entity) => spl_object_hash($entity),
            is_array($entity) => md5(serialize($entity)),
            is_string($entity) => $entity
        };
    }

    public function makeRelation(object|array|string $entityKey, object|array $entity): void
    {
        $key = $this->computeHash($entityKey);
        $this->map[$key] = $entity;
    }

    public function clear(): void
    {
        $this->map = [];
    }
}