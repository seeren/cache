<?php

namespace Seeren\Cache\Item;

use DateTimeInterface;
use Psr\Cache\CacheItemInterface;
use DateInterval;
use DateTime;

/**
 * Class to represent a cache item
 *
 *     __
 *    / /__ __ __ __ __ __
 *   / // // // // // // /
 *  /_// // // // // // /
 *    /_//_//_//_//_//_/
 *
 * @package Seeren\Cache\Item
 */
class CacheItem implements ModifiedItemInterface
{

    /**
     * @var string
     */
    private string $key;

    /**
     * @var string
     */
    private string $value;

    /**
     * @var bool
     */
    private bool $hit;

    /**
     * @var int
     */
    private int $timeToLive;

    /**
     * @var int
     */
    private int $lastSave;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
        $this->hit = false;
        $this->timeToLive = 0;
        $this->lastSave = time();
    }

    /**
     * {@inheritDoc}
     * @see ModifiedItemInterface::last()
     */
    public final function last(): string
    {
        return gmdate('D, d M Y H:i:s', $this->lastSave) . ' GMT';
    }

    /**
     * {@inheritDoc}
     * @see CacheItemInterface::getKey()
     */
    public final function getKey(): string
    {
        return $this->key;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemInterface::get()
     */
    public final function get()
    {
        return $this->value;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemInterface::isHit()
     */
    public final function isHit(): bool
    {
        return $this->hit;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemInterface::set()
     */
    public final function set($value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemInterface::expiresAt()
     */
    public final function expiresAt($expiration)
    {
        $this->timeToLive = $expiration instanceof DateTimeInterface ? $expiration->getTimestamp() - time() : 0;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemInterface::expiresAfter()
     */
    public final function expiresAfter($time)
    {
        $this->timeToLive = $time instanceof DateInterval
            ? (new DateTime())->add($time)->getTimestamp() - time()
            : (is_int($time) ? $time : 0);
        return $this;
    }

    /**
     * @return string[]
     */
    public final function __sleep()
    {
        $this->lastSave = time();
        return [
            "key",
            "hit",
            "timeToLive",
            "lastSave",
            "value"
        ];
    }

    /**
     * @return void
     */
    public final function __wakeup(): void
    {
        $this->hit = 0 === $this->timeToLive || $this->lastSave + $this->timeToLive > time();
    }

}
