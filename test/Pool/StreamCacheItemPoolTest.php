<?php

/**
 * This file contain Seeren\Cache\Test\Pool\StreamCacheItemPoolTest class
 *     __
 *    / /__ __ __ __ __ __
 *   / // // // // // // /
 *  /_// // // // // // /
 *    /_//_//_//_//_//_/
 *
 * @copyright (c) Cyril Ichti <consultant@seeren.fr>
 * @link https://github.com/seeren/cache
 * @version 2.0.2
 */

namespace Seeren\Cache\Test;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Seeren\Cache\Pool\StreamCacheItemPool;
use ReflectionClass;

/**
 * Class for test StreamCacheItemPoolInterface
 * 
 * @category Seeren
 * @package Cache
 * @subpackage Test\Pool
 */
class StreamCacheItemPoolTest extends AbstractCacheItemPoolTest
{

    /**
     * Get CacheItemPoolInterface
     *
     * @return CacheItemPoolInterface pool
     */
   protected function getCacheItemPool(): CacheItemPoolInterface
   {
       return (new ReflectionClass(StreamCacheItemPool::class))
              ->newInstanceArgs(["./test/cache"]);
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getTarget
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolGetItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::createItem
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    */
   public function testGetItem()
   {
       parent::assertGetItem();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Exception\InvalidArgumentException::__construct
    * @expectedException \Psr\Cache\InvalidArgumentException
    */
   public function testGetItemInvalidArgumentException()
   {
       parent::assertGetItemInvalidArgumentException();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getTarget
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolGetItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItems
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::createItem
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    */
   public function testGetItems()
   {
       parent::assertGetItems();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItems
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Exception\InvalidArgumentException::__construct
    * @expectedException \Psr\Cache\InvalidArgumentException
    */
   public function testGetItemsInvalidArgumentException()
   {
       parent::assertGetItemsInvalidArgumentException();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::createItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getTarget
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolGetItem
    */
   public function testHasItem()
   {
       parent::assertHasItem();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Exception\InvalidArgumentException::__construct
    * @expectedException \Psr\Cache\InvalidArgumentException
    */
   public function testHasItemInvalidArgumentException()
   {
       parent::assertHasItemInvalidArgumentException();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::createItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getTarget
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolDeleteItem
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolGetItem
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::clear
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::getKey
    * @covers \Seeren\Cache\Item\CacheItem::last
    */
   public function testClearTrue()
   {
       parent::assertClearTrue();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::createItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::clear
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getTarget
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolDeleteItem
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolGetItem
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::getKey
    * @covers \Seeren\Cache\Item\CacheItem::last
    */
   public function testClearFalse()
   {
       $pool = $this->getCacheItemPool();
       $pool->__construct();
       $uniqId = uniqid();
       $pool->getItem("dummy." . $uniqId);
       unlink(sys_get_temp_dir() . "/dummy/" . $uniqId);
       $this->assertFalse($pool->clear());
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::createItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItem
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getTarget
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolDeleteItem
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolGetItem
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::getKey
    * @covers \Seeren\Cache\Item\CacheItem::last
    */
   public function testDeleteItemTrue()
   {
       parent::assertDeleteItemTrue();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItem
    */
   public function testDeleteItemFalse()
   {
        parent::assertDeleteItemFalse();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::createItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItem
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getTarget
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolDeleteItem
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolGetItem
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::getKey
    * @covers \Seeren\Cache\Item\CacheItem::last
    */
   public function testDeleteItemFalseUnlinked()
   {
       $pool = $this->getCacheItemPool();
       $uniqId = uniqid();
       $pool->getItem($uniqId);
       unlink(__DIR__ . "/../cache/" . $uniqId);
       $this->assertFalse($pool->deleteItem($uniqId));
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItem
    * @covers \Seeren\Cache\Exception\InvalidArgumentException::__construct
    * @expectedException \Psr\Cache\InvalidArgumentException
    */
   public function testDeleteItemInvalidArgumentException()
   {
        parent::assertDeleteItemInvalidArgumentException();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::createItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItems
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getTarget
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolDeleteItem
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolGetItem
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::getKey
    * @covers \Seeren\Cache\Item\CacheItem::last
    */
   public function testDeleteItemsTrue()
   {
       parent::assertDeleteItemsTrue();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItems
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItem
    */
   public function testDeleteItemsFalse()
   {
       parent::assertDeleteItemsFalse();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItems
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItem
    * @covers \Seeren\Cache\Exception\InvalidArgumentException::__construct
    * @expectedException \Psr\Cache\InvalidArgumentException
    */
   public function testDeleteItemsInvalidArgumentException()
   {
        parent::assertDeleteItemsInvalidArgumentException();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getTarget
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolGetItem
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::save
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolSave
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::createItem
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Item\CacheItem::__sleep
    * @covers \Seeren\Cache\Item\CacheItem::__wakeup
    * @covers \Seeren\Cache\Item\CacheItem::set
    * @covers \Seeren\Cache\Item\CacheItem::getKey
    */
   public function testSaveTrue()
   {
       parent::assertSaveTrue();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getTarget
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolGetItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::createItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::saveDeferred
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    */
   public function testSaveDeferedTrue()
   {
       parent::assertSaveDeferedTrue();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getTarget
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolGetItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::createItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::saveDeferred
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    */
   public function testSaveDeferedFalse()
   {
       parent::assertSaveDeferedFalse();
   }

   /**
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getTarget
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolGetItem
    * @covers \Seeren\Cache\Pool\StreamCacheItemPool::poolSave
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::__construct
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::createItem
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::saveDeferred
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::commit
    * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::save
    * @covers \Seeren\Cache\Item\CacheItem::__construct
    * @covers \Seeren\Cache\Item\CacheItem::last
    * @covers \Seeren\Cache\Item\CacheItem::__sleep
    * @covers \Seeren\Cache\Item\CacheItem::getKey
    */
   public function testCommitTrue()
   {
       parent::assertCommitTrue();
   }

}
