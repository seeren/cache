<?php

namespace Seeren\Cache\Item;

use DateTimeInterface;
use DateInterval;
use DateTime;

class CacheItem implements ModifiedItemInterface
{

    private ?string $value = null;

    private bool $hit = false;

    private int $timeToLive = 0;

    private int $lastSave;

    public function __construct(private string $key)
    {
        $this->lastSave = time();
    }

    public final function last(bool $expires = false): string
    {
        return gmdate(
                'D, d M Y H:i:s',
                $this->lastSave + ($expires ? $this->timeToLive : 0)
            ) . ' GMT';
    }

    public final function getKey(): string
    {
        return $this->key;
    }

    public final function get(): mixed
    {
        return $this->value;
    }

    public final function isHit(): bool
    {
        return $this->hit;
    }

    public final function set(mixed $value): static
    {
        $this->value = $value;
        return $this;
    }

    public final function expiresAt(?DateTimeInterface $expiration): static
    {
        $this->timeToLive = $expiration ? $expiration->getTimestamp() - time() : 0;
        return $this;
    }

    public final function expiresAfter(int|DateInterval|null $time): static
    {
        $this->timeToLive = $time instanceof DateInterval
            ? (new DateTime())->add($time)->getTimestamp() - time()
            : (is_int($time) ? $time : 0);
        return $this;
    }

    public final function __sleep(): array
    {
        $this->lastSave = time();
        return [
            'key',
            'hit',
            'timeToLive',
            'lastSave',
            'value'
        ];
    }

    public final function __wakeup(): void
    {
        $this->hit = 0 === $this->timeToLive || $this->lastSave + $this->timeToLive > time();
    }

}
