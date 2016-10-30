<?php

/**
 * This file contain Seeren\Cache\Test\CacheItemInterfaceTest class
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

use Psr\Cache\CacheItemInterface;
use Seeren\Cache\Item\CacheItem;
use ReflectionClass;
/**
 * Class for test CacheItem
 * 
 * @category Seeren
 * @package Cache
 * @subpackage Test
 */
class CacheItemTest extends CacheItemInterfaceTest
{

    /**
     * Get CacheItemInterface
     *
     * @return CacheItemInterface cache
     */
   protected function getCacheItemInterface(): CacheItemInterface
   {
       return (new ReflectionClass(CacheItem::class))->newInstanceArgs([]);
   }

}
