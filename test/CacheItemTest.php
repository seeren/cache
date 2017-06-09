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
 * @link https://github.com/seeren/cache
 * @version 2.0.1
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
class CacheItemTest extends AbstractCacheItemTest
{

    /**
     * Get CacheItemInterface
     *
     * @return CacheItemInterface cache
     */
   protected final function getCacheItem(): CacheItemInterface
   {
       return (new ReflectionClass(CacheItem::class))->newInstanceArgs([]);
   }

   /**
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Item\CacheItem::getKey
    */
   public function testGetKey()
   {
       parent::assertGetKey();
   }

   /**
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Item\CacheItem::get
    */
   public function testGet()
   {
       parent::assertGet();
   }

   /**
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Item\CacheItem::set
    * @covers \Seeren\Cache\Item\CacheItem::get
    */
   public function testSet()
   {
       parent::assertSet();
   }

   /**
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Item\CacheItem::__sleep
    * @covers \Seeren\Cache\Item\CacheItem::set
    */
   public function testSerialize()
   {
       parent::assertSerialize();
   }

   /**
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Item\CacheItem::__sleep
    * @covers \Seeren\Cache\Item\CacheItem::__wakeup
    * @covers \Seeren\Cache\Item\CacheItem::get
    * @covers \Seeren\Cache\Item\CacheItem::getKey
    * @covers \Seeren\Cache\Item\CacheItem::set
    */
   public function testUnserialize()
   {
       parent::assertUnserialize();
   }

   /**
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Item\CacheItem::isHit
    */
   public function testIsHitFalse()
   {
       parent::assertIsHitFalse();
   }

   /**
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Item\CacheItem::isHit
    * @covers \Seeren\Cache\Item\CacheItem::__sleep
    * @covers \Seeren\Cache\Item\CacheItem::__wakeup
    */
   public function testIsHitTrue()
   {
       parent::assertIsHitTrue();
   }

   /**
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Item\CacheItem::expiresAfter
    * @covers \Seeren\Cache\Item\CacheItem::__wakeup
    * @covers \Seeren\Cache\Item\CacheItem::isHit
    */
   public function testExpiresAfter()
   {
       parent::assertExpiresAfter();
   }

   /**
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Item\CacheItem::expiresAfter
    * @covers \Seeren\Cache\Item\CacheItem::__wakeup
    * @covers \Seeren\Cache\Item\CacheItem::isHit
    */
   public function testExpiresAfterDateInterval()
   {
       parent::assertExpiresAfterDateInterval();
   }

   /**
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    */
   public function testLast()
   {
        parent::assertLast();
   }

   /**
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Item\CacheItem::expiresAt
    * @covers \Seeren\Cache\Item\CacheItem::__wakeup
    * @covers \Seeren\Cache\Item\CacheItem::isHit
    */
   public function testExpiresAt()
   {
       parent::assertExpiresAt();
   }

   /**
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Item\CacheItem::expiresAt
    * @covers \Seeren\Cache\Item\CacheItem::__wakeup
    * @covers \Seeren\Cache\Item\CacheItem::isHit
    */
   public function testExpiresAtDate()
   {
       parent::assertExpiresAtDate();
   }

   /**
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Item\CacheItem::getKey
    */
   public function testKey()
   {
       parent::assertKey();
   }

   /**
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Item\CacheItem::expiresAt
    * @covers \Seeren\Cache\Item\CacheItem::__wakeup
    * @covers \Seeren\Cache\Item\CacheItem::isHit
    */
   public function test__wakeup()
   {
       parent::assert__wakeup();
   }

}
