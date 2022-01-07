<?php

namespace Seeren\Cache\Pool;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\CacheItemInterface;
use Seeren\Cache\Exception\InvalidArgumentException;

abstract class AbstractCacheItemPool implements CacheItemPoolInterface
{

    private array $pool = [];

    private array $queue = [];

    abstract protected function create(string $key): CacheItemInterface;

    abstract protected function persist(CacheItemInterface $item): bool;

    abstract protected function remove(CacheItemInterface $item): bool;

    /**
     * @throws InvalidArgumentException
     */
    private function validateKey(string $key): string
    {
        if (!preg_match('/^[A-Za-z0-9_.]{1,64}$/', $key)) {
            throw new InvalidArgumentException('Invalid CacheItem key: "' . $key . '\"');
        }
        return $key;
    }

    public final function getItem(string $key): CacheItemInterface
    {
        if (!$this->hasItem($this->validateKey($key))) {
            $this->pool[$key] = $this->create($key);
        }
        return $this->pool[$key];
    }

    public final function getItems(array $keys = []): array
    {
        $items = [];
        foreach ($keys as $key) {
            $items[$key] = $this->getItem($key);
        }
        return $items;
    }

    public final function hasItem(string $key): bool
    {
        return array_key_exists($this->validateKey($key), $this->pool);
    }

    public final function clear(): bool
    {
        foreach ($this->pool as $value) {
            if (!$this->remove($value)) {
                return false;
            }
        }
        return true;
    }

    public final function deleteItem(string $key): bool
    {
        if (!$this->hasItem($key)) {
            return false;
        }
        unset($this->pool[$key]);
        return true;
    }

    public final function deleteItems(array $keys): bool
    {
        foreach ($keys as $key) {
            if (!$this->deleteItem($key)) {
                return false;
            }
        }
        return true;
    }

    public final function save(CacheItemInterface $item): bool
    {
        return $this->persist($item);
    }

    public final function saveDeferred(CacheItemInterface $item): bool
    {
        if (in_array($item, $this->queue)) {
            return false;
        }
        $this->queue[] = $item;
        return true;
    }

    public final function commit(): bool
    {
        foreach ($this->queue as $key => $value) {
            if (!$this->save($value)) {
                return false;
            }
            unset($this->queue[$key]);
        }
        return true;
    }

}
