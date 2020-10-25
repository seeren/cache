# Seeren\Cache

[![Build Status](https://travis-ci.org/seeren/cache.svg?branch=master)](https://travis-ci.org/seeren/cache) [![Coverage Status](https://coveralls.io/repos/github/seeren/cache/badge.svg?branch=master)](https://coveralls.io/github/seeren/cache?branch=master) [![Packagist](https://img.shields.io/packagist/dt/seeren/cache.svg)](https://packagist.org/packages/seeren/cache/stats) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/4a0463fb5a084be5bda68e4e36d7c7ac)](https://www.codacy.com/app/seeren/cache?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=seeren/cache&amp;utm_campaign=Badge_Grade) [![Packagist](https://img.shields.io/packagist/v/seeren/cache.svg)](https://packagist.org/packages/seeren/cache#) [![Packagist](https://img.shields.io/packagist/l/seeren/log.svg)](LICENSE)

Cache items in pool

## Installation

Seeren\Cache is a [PSR-6 cache interfaces](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-6-cache.md) implementation

```
composer require seeren/cache
```

## Seeren\Cache\StreamCacheItemPool

Store item in stream pool

```php
use Seeren\Cache\Pool\StreamCacheItemPool;

$pool = new StreamCacheItemPool();
$item = $pool
    ->getItem('foo')
    ->expiresAfter(5);
if (!$item->isHit()) {
    $item->set("item data");
    $pool->save();
}
$data = $item->get();
```

By default, cache folder is in /var/cache

```bash
project/
└─ var/
   └─ log/
```

## Seeren\Cache\CacheItem

Use item for manage Last-Modified with the extra method `last`

```php
$response = $response
->withHeader("ETag", $eTag)
->withHeader("Last-Modified", $item->last())
->withHeader("Cache-Control", "public, max-age=" . $timeToLive)
->withHeader("Expires", $item->last(true));
```

> Passing true at `last` add the timeToLive to the lastSave timestamp.

## License

This project is licensed under the MIT License