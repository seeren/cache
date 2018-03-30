# cache
 [![Build Status](https://travis-ci.org/seeren/cache.svg?branch=master)](https://travis-ci.org/seeren/cache) [![Coverage Status](https://coveralls.io/repos/github/seeren/cache/badge.svg?branch=master)](https://coveralls.io/github/seeren/cache?branch=master) [![Packagist](https://img.shields.io/packagist/dt/seeren/cache.svg)](https://packagist.org/packages/seeren/cache/stats) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/4a0463fb5a084be5bda68e4e36d7c7ac)](https://www.codacy.com/app/seeren/cache?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=seeren/cache&amp;utm_campaign=Badge_Grade) [![Packagist](https://img.shields.io/packagist/v/seeren/cache.svg)](https://packagist.org/packages/seeren/cache#) [![Packagist](https://img.shields.io/packagist/l/seeren/log.svg)](LICENSE)

**Manage pool items**
> This package contain implementations of the [PSR-6 cache interfaces](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-6-cache.md)

## Features
* Manage cache pool and items

## Installation
Require this package with [composer](https://getcomposer.org/)
```
composer require seeren/cache dev-master
```

## Usage
#### `Seeren\Cache\StreamCacheItemPool`
Store data in pool item
```php
$pool = new StreamCacheItemPool;
$eTag = md5($request->getUri()->getPath());
$item = $pool->getItem($eTag)->expiresAfter(600);
if (!$item->isHit()) {
    $pool->save($item->set("data");
}
$data = $item->get();
```

#### `Seeren\Cache\CacheItem`
Use item for manage Last-Modified
```php
if ($item->last() === $request->getHeaderLine("If-Modified-Since")
 && $eTag === $request->getHeaderLine("If-None-Match")) {
    $response = $response->withStatus(304);
} 
```

Use item for manage Expires
```php
$response = $response
->withHeader("ETag", $eTag)
->withHeader("Last-Modified", $item->last())
->withHeader("Cache-Control", "public, max-age=" . $timeToLive)
->withHeader("Expires", $item->last(time() + $timeToLive));
```

## Run Tests
Run [phpunit](https://phpunit.de/) with [Xdebug](https://xdebug.org/) enable and [OPcache](http://php.net/manual/fr/book.opcache.php) disable
```
./vendor/bin/phpunit
```

## Run Coverage
Run [coveralls](https://coveralls.io/)
```
./vendor/bin/php-coveralls -v
```

## License
This project is licensed under the **MIT License** - see the [license](LICENSE) file for details.