<?php

namespace Seeren\Cache\Pool;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\CacheItemInterface;
use Seeren\Cache\Exception\InvalidArgumentException;

/**
 * Class to represent a cache pool
 *
 *     __
 *    / /__ __ __ __ __ __
 *   / // // // // // // /
 *  /_// // // // // // /
 *    /_//_//_//_//_//_/
 *
 * @package Seeren\Cache\Pool
 */
abstract class AbstractCacheItemPool implements CacheItemPoolInterface
{

    /**
     * @var array
     */
    private array $pool = [];

    /**
     * @var array
     */
    private array $queue = [];

    /**
     * @param string $key
     * @return CacheItemInterface
     */
    abstract protected function create(string $key): CacheItemInterface;

    /**
     * @param CacheItemInterface $item
     * @return bool
     */
    abstract protected function persist(CacheItemInterface $item): bool;

    /**
     * @param CacheItemInterface $item
     * @return bool
     */
    abstract protected function remove(CacheItemInterface $item): bool;

    /**
     * @param string $key
     * @return string
     * @throws InvalidArgumentException
     */
    private function validateKey(string $key): string
    {
        if (!preg_match('/^[A-Za-z0-9_.]{1,64}$/', $key)) {
            throw new InvalidArgumentException('Invalid CacheItem key: "' . $key . '\"');
        }
        return $key;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemPoolInterface::getItem()
     */
    public function getItem($key): CacheItemInterface
    {
        if (!$this->hasItem($this->validateKey($key))) {
            $this->pool[$key] = $this->create($key);
        }
        return $this->pool[$key];
    }

    /**
     * {@inheritDoc}
     * @see CacheItemPoolInterface::getItems()
     */
    public function getItems(array $keys = []): array
    {
        $items = [];
        foreach ($keys as $key) {
            $items[$key] = $this->getItem($key);
        }
        return $items;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemPoolInterface::hasItem()
     */
    public function hasItem($key): bool
    {
        return array_key_exists($this->validateKey($key), $this->pool);
    }

    /**
     * {@inheritDoc}
     * @see CacheItemPoolInterface::clear()
     */
    public function clear(): bool
    {
        foreach ($this->pool as $value) {
            if (!$this->remove($value)) {
                return false;
            }
        }
        return true;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemPoolInterface::deleteItem()
     */
    public function deleteItem($key): bool
    {
        if (!$this->hasItem($key)) {
            return false;
        }
        unset($this->pool[$key]);
        return true;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemPoolInterface::deleteItems()
     */
    public function deleteItems(array $keys): bool
    {
        foreach ($keys as $key) {
            if (!$this->deleteItem($key)) {
                return false;
            }
        }
        return true;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemPoolInterface::save()
     */
    public function save(CacheItemInterface $item): bool
    {
        return $this->persist($item);
    }

    /**
     * {@inheritDoc}
     * @see CacheItemPoolInterface::saveDeferred()
     */
    public function saveDeferred(CacheItemInterface $item): bool
    {
        if (in_array($item, $this->queue)) {
            return false;
        }
        $this->queue[] = $item;
        return true;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemPoolInterface::commit()
     */
    public function commit(): bool
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
