[![Build Status](https://travis-ci.org/seeren/cache.svg?branch=master)](https://travis-ci.org/seeren/cache) [![GitHub license](https://img.shields.io/badge/license-MIT-orange.svg)](https://raw.githubusercontent.com/seeren/cache/master/LICENSE) [![Packagist](https://img.shields.io/packagist/v/seeren/cache.svg)]() [![Packagist](https://img.shields.io/packagist/dt/seeren/cache.svg)]()

# Seeren\Cache\
Psr-6 implementation with stream interface adapter.
Performance as standard for controllers: get a pool driver then manage cache item's.

## Seeren\Cache\StreamCacheItemPool
Adapter for psr 7 stream interface. AbstractCacheItemPool implements methods from psr-6 and declare template method for get, post and delete item for driver adapters.
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

## Seeren\Cache\CacheItem
CacheItem is lighter as possible and can't be extended: pools have to manage items, but items can't manage them self. An extra method provide GMT date of last modified that is not the last saved date time. 
```php
$response = $response
->withHeader("ETag", $eTag)
->withHeader("Last-Modified", $item->last())
->withHeader("Cache-Control", "public, max-age=" . $timeToLive)
->withHeader("Expires", $item->last(time() + $timeToLive));
```

## Installation
Require this package with composer
```
composer require seeren/cache dev-master
```

## Run the tests
Run with phpunit after install dependencies
```
composer update
phpunit
```

## Authors
* **Cyril Ichti** - [www.seeren.fr](http://www.seeren.fr)