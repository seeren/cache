# Seeren\\Cache

[![Build](https://app.travis-ci.com/seeren/http.svg?branch=master)](https://app.travis-ci.com/seeren/cache)
[![Require](https://poser.pugx.org/seeren/cache/require/php)](https://packagist.org/packages/seeren/cache)
[![Coverage](https://coveralls.io/repos/github/seeren/error/badge.svg?branch=master)](https://coveralls.io/github/seeren/cache?branch=master)
[![Download](https://img.shields.io/packagist/dt/seeren/cache.svg)](https://packagist.org/packages/seeren/cache/stats)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/9d4e2d4c99914c569d6b6a19b8fb4f1d)](https://www.codacy.com/gh/seeren/cache/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=seeren/cache&amp;utm_campaign=Badge_Grade)
[![Version](https://img.shields.io/packagist/v/seeren/cache.svg)](https://packagist.org/packages/seeren/cache)

Cache items in pool

## Installation

Seeren\\Cache is a [PSR-6 cache interfaces](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-6-cache.md) implementation

```bash
composer require seeren/cache
```

* * *

## Seeren\\Cache\\StreamCacheItemPool

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

* * *

## Seeren\\Cache\\CacheItem

Use item for manage `Last-Modified` with the extra method `last`

```php
$response = $response
    ->withHeader("ETag", $eTag)
    ->withHeader("Last-Modified", $item->last())
    ->withHeader("Cache-Control", "public, max-age=" . $timeToLive)
    ->withHeader("Expires", $item->last(true));
```

> Passing true at `last` add the timeToLive to the lastSave timestamp

* * *

## License

This project is licensed under the [MIT](./LICENSE) License
