<?php

/**
 * This file contain Seeren\Cache\Test\StreamCacheItemPoolTest class
 *     __
 *    / /__ __ __ __ __ __
 *   / // // // // // // /
 *  /_// // // // // // /
 *    /_//_//_//_//_//_/
 *
 * @copyright (c) Cyril Ichti <consultant@seeren.fr>
 * @link http://www.seeren.fr/ Seeren
 * @version 1.0.1
 */

namespace Seeren\Cache\Test;

use Psr\Cache\CacheItemPoolInterface;
use Seeren\Cache\Pool\StreamCacheItemPool;
use ReflectionClass;

/**
 * Class for test StreamCacheItemPoolInterface
 * 
 * @category Seeren
 * @package Cache
 * @subpackage Test
 */
class StreamCacheItemPoolTest extends CacheItemPoolInterfaceTest
{

    /**
     * Get CacheItemPoolInterface
     *
     * @return CacheItemPoolInterface pool
     */
   protected function getCacheItemPoolInterface(): CacheItemPoolInterface
   {
       return (new ReflectionClass(StreamCacheItemPool::class))->newInstanceArgs([]);
   }

}
