<?php

/**
 * This file contain Seeren\Cache\Test\Pool\AbstractCacheItemPoolTest class
 *     __
 *    / /__ __ __ __ __ __
 *   / // // // // // // /
 *  /_// // // // // // /
 *    /_//_//_//_//_//_/
 *
 * @copyright (c) Cyril Ichti <consultant@seeren.fr>
 * @link https://github.com/seeren/cache
 * @version 1.0.2
 */

namespace Seeren\Cache\Test;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\CacheItemInterface;
use stdClass;

/**
 * Class for test CacheItemPoolInterface
 * 
 * @category Seeren
 * @package Cache
 * @subpackage Test\Pool
 * @abstract
 */
abstract class AbstractCacheItemPoolTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Get CacheItemPoolInterface
     *
     * @return CacheItemPoolInterface pool
     */
   abstract protected function getCacheItemPool(): CacheItemPoolInterface;

   /**
    * Test clear false
    */
   abstract public function testClearFalse();

   /**
    * Asert get item
    */
   public function testGetItem()
   {
       $this->assertTrue($this->getCacheItemPool()->getItem(uniqid())
              instanceof CacheItemInterface);
   }

   /**
    * Test get item InvalidArgumentException
    */
   public function testGetItemInvalidArgumentException()
   {
       $this->getCacheItemPool()->getItem("|");
   }

   /**
    * Asert get items
    */
   public function testGetItems()
   {
       $uniqId = uniqid();
       $this->assertTrue($this->getCacheItemPool()->getItems([$uniqId])[$uniqId]
              instanceof CacheItemInterface);
   }

   /**
    * Asert get items InvalidArgumentException
    */
   public function testGetItemsInvalidArgumentException()
   {
       $this->getCacheItemPool()->getItems(["|"]);
   }

   /**
    * Test has item
    */
   public function testHasItem()
   {
       $pool = $this->getCacheItemPool();
       $uniqId = uniqid();
       $pool->getItem($uniqId);
       $this->assertTrue($pool->hasItem($uniqId));
   }

   /**
    * 
    * Test has item InvalidArgumentException
    */
   public function testHasItemInvalidArgumentException()
   {
       $this->getCacheItemPool()->hasItem("|");
   }

   /**
    * Test clear true
    */
   public function testClearTrue()
   {
       $pool = $this->getCacheItemPool();
       $uniqId = uniqid();
       $pool->getItem($uniqId);
       $this->assertTrue($pool->clear($uniqId));
   }

   /**
    * Test delete item true
    */
   public function testDeleteItemTrue()
   {
       $pool = $this->getCacheItemPool();
       $uniqId = uniqid();
       $pool->getItem($uniqId);
       $this->assertTrue($pool->deleteItem($uniqId));
   }

   /**
    * Test delete item false
    */
   public function testDeleteItemFalse()
   {
       $this->assertFalse($this->getCacheItemPool()->deleteItem(uniqid()));
   }

   /**
    * Test delete item InvalidArgumentException
    */
   public function testDeleteItemInvalidArgumentException()
   {
       $this->assertFalse($this->getCacheItemPool()->deleteItem("|"));
   }

   /**
    * Test delete items true
    */
   public function testDeleteItemsTrue()
   {
       $pool = $this->getCacheItemPool();
       $uniqId = uniqid();
       $pool->getItem($uniqId);
       $this->assertTrue($pool->deleteItems([$uniqId]));
   }

   /**
    * Test delete items false
    */
   public function testDeleteItemsFalse()
   {
       $this->assertFalse($this->getCacheItemPool()->deleteItems([uniqid()]));
   }

   /**
    * Test delete items InvalidArgumentException
    */
   public function testDeleteItemsInvalidArgumentException()
   {
       $this->assertFalse($this->getCacheItemPool()->deleteItems(["|"]));
   }

   /**
    * Test save true
    */
   public function testSaveTrue()
   {
       $pool = $this->getCacheItemPool();
       $uniqId = uniqid();
       $item = $this->getCacheItemPool()->getItem($uniqId);
       $item->set(new stdClass());
       $pool->save($item);
       $this->assertTrue($pool->save($pool->getItem($uniqId)));
   }

   /**
    * Test save defered true
    */
   public function testSaveDeferedTrue()
   {
       $pool = $this->getCacheItemPool();
       $this->assertTrue($pool->saveDeferred($pool->getItem(uniqid())));
   }

   /**
    * Test save defered false
    */
   public function testSaveDeferedFalse()
   {
       $pool = $this->getCacheItemPool();
       $item = $pool->getItem(uniqid());
       $pool->saveDeferred($item);
       $this->assertFalse($pool->saveDeferred($item));
   }

   /**
    * Test commit true
    */
   public function testCommitTrue()
   {
       $pool = $this->getCacheItemPool();
       $item = $pool->getItem(uniqid());
       $pool->saveDeferred($item);
       $this->assertTrue($pool->commit());
   }

}
