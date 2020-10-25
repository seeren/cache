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
     * @var ?string
     */
    private ?string $value = null;

    /**
     * @var bool
     */
    private bool $hit = false;

    /**
     * @var int
     */
    private int $timeToLive = 0;

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
        $this->lastSave = time();
    }

    /**
     * {@inheritDoc}
     * @see ModifiedItemInterface::last()
     */
    public function last(bool $expires = false): string
    {
        return gmdate('D, d M Y H:i:s', $this->lastSave + ($expires ? $this->timeToLive : 0)) . ' GMT';
    }

    /**
     * {@inheritDoc}
     * @see CacheItemInterface::getKey()
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemInterface::get()
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemInterface::isHit()
     */
    public function isHit(): bool
    {
        return $this->hit;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemInterface::set()
     */
    public function set($value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemInterface::expiresAt()
     */
    public function expiresAt($expiration): self
    {
        $this->timeToLive = $expiration instanceof DateTimeInterface ? $expiration->getTimestamp() - time() : 0;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see CacheItemInterface::expiresAfter()
     */
    public function expiresAfter($time): self
    {
        $this->timeToLive = $time instanceof DateInterval
            ? (new DateTime())->add($time)->getTimestamp() - time()
            : (is_int($time) ? $time : 0);
        return $this;
    }

    /**
     * @return string[]
     */
    public function __sleep(): array
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
    public function __wakeup(): void
    {
        $this->hit = 0 === $this->timeToLive || $this->lastSave + $this->timeToLive > time();
    }

}
