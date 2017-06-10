# cache
 [![Build Status](https://travis-ci.org/seeren/cache.svg?branch=master)](https://travis-ci.org/seeren/cache) [![Coverage Status](https://coveralls.io/repos/github/seeren/cache/badge.svg?branch=master)](https://coveralls.io/github/seeren/cache?branch=master) [![Packagist](https://img.shields.io/packagist/dt/seeren/cache.svg)](https://packagist.org/packages/seeren/cache/stats) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/4a0463fb5a084be5bda68e4e36d7c7ac)](https://www.codacy.com/app/seeren/cache?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=seeren/cache&amp;utm_campaign=Badge_Grade) [![Packagist](https://img.shields.io/packagist/v/seeren/cache.svg)](https://packagist.org/packages/seeren/cache#) [![Packagist](https://img.shields.io/packagist/l/seeren/log.svg)](LICENSE)

**Get a pool driver then manage cache items**

## Features
* [Psr-6](http://www.php-fig.org/psr/psr-6/) implementation
* Manage cache items
## Installation
Require this package with [composer](https://getcomposer.org/)
```
composer require seeren/cache dev-master
```

## Pool Usage

#### `Seeren\Cache\StreamCacheItemPool`
This example show how to manage a cache, checking item expiration, last modification and request ETag.
```php
$pool = new StreamCacheItemPool;
$eTag = md5($request->getUri()->getPath());
$item = $pool->getItem($eTag)->expiresAfter(600);

if (!$item->isHit()) {
    $pool->save($item->set($model->get());
} else if ($item->last() !== $request->getHeaderLine("If-Modified-Since")
        || $eTag !== $request->getHeaderLine("If-None-Match")) {
    $view->update($item->get());
} else {
    $response = $response->withStatus(304);
}
```
## Item Usage

#### `Seeren\Cache\CacheItem`
Pools have to manage items, but the item last() method can be used for formatting GMT date 
```php
$response = $response
->withHeader("ETag", $eTag)
->withHeader("Last-Modified", $item->last())
->withHeader("Cache-Control", "public, max-age=" . $timeToLive)
->withHeader("Expires", $item->last(time() + $timeToLive));
```

## Run Unit tests
Install dependencies
```
composer update
```
Run [phpunit](https://phpunit.de/) with [Xdebug](https://xdebug.org/) enabled and [OPcache](http://php.net/manual/fr/book.opcache.php) disabled for coverage
```
./vendor/bin/phpunit
```
## Run Coverage
Install dependencies
```
composer update
```
Run [coveralls](https://coveralls.io/) for check coverage
```
./vendor/bin/coveralls -v
```

##  Contributors
* **Cyril Ichti** - *Initial work* - [seeren](https://github.com/seeren)

## License
This project is licensed under the **MIT License** - see the [license](LICENSE) file for details.