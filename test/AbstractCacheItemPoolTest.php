<?php

/**
 * This file contain Seeren\Cache\Test\AbstractCacheItemPoolTest class
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
 * @subpackage Test
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
   protected function assertGetItem()
   {
       $this->assertTrue($this->getCacheItemPool()->getItem(uniqid())
              instanceof CacheItemInterface);
   }

   /**
    * Assert get item InvalidArgumentException
    */
   protected function assertGetItemInvalidArgumentException()
   {
       $this->getCacheItemPool()->getItem("|");
   }

   /**
    * Asert get items
    */
   protected function assertGetItems()
   {
       $uniqId = uniqid();
       $this->assertTrue($this->getCacheItemPool()->getItems([$uniqId])[$uniqId]
              instanceof CacheItemInterface);
   }

   /**
    * Asert get items InvalidArgumentException
    */
   protected function assertGetItemsInvalidArgumentException()
   {
       $this->getCacheItemPool()->getItems(["|"]);
   }

   /**
    * Assert has item
    */
   protected function assertHasItem()
   {
       $pool = $this->getCacheItemPool();
       $uniqId = uniqid();
       $pool->getItem($uniqId);
       $this->assertTrue($pool->hasItem($uniqId));
   }

   /**
    * 
    * Assert has item InvalidArgumentException
    */
   protected function assertHasItemInvalidArgumentException()
   {
       $this->getCacheItemPool()->hasItem("|");
   }

   /**
    * Assert clear true
    */
   protected function assertClearTrue()
   {
       $pool = $this->getCacheItemPool();
       $uniqId = uniqid();
       $pool->getItem($uniqId);
       $this->assertTrue($pool->clear($uniqId));
   }

   /**
    * Assert delete item true
    */
   protected function assertDeleteItemTrue()
   {
       $pool = $this->getCacheItemPool();
       $uniqId = uniqid();
       $pool->getItem($uniqId);
       $this->assertTrue($pool->deleteItem($uniqId));
   }

   /**
    * Assert delete item false
    */
   protected function assertDeleteItemFalse()
   {
       $this->assertFalse($this->getCacheItemPool()->deleteItem(uniqid()));
   }

   /**
    * Assert delete item InvalidArgumentException
    */
   protected function assertDeleteItemInvalidArgumentException()
   {
       $this->assertFalse($this->getCacheItemPool()->deleteItem("|"));
   }

   /**
    * Assert delete items true
    */
   protected function assertDeleteItemsTrue()
   {
       $pool = $this->getCacheItemPool();
       $uniqId = uniqid();
       $pool->getItem($uniqId);
       $this->assertTrue($pool->deleteItems([$uniqId]));
   }

   /**
    * Assert delete items false
    */
   protected function assertDeleteItemsFalse()
   {
       $this->assertFalse($this->getCacheItemPool()->deleteItems([uniqid()]));
   }

   /**
    * Assert delete items InvalidArgumentException
    */
   protected function assertDeleteItemsInvalidArgumentException()
   {
       $this->assertFalse($this->getCacheItemPool()->deleteItems(["|"]));
   }

   /**
    * Assert save true
    */
   protected function assertSaveTrue()
   {
       $pool = $this->getCacheItemPool();
       $uniqId = uniqid();
       $item = $this->getCacheItemPool()->getItem($uniqId);
       $item->set(new stdClass());
       $pool->save($item);
       $this->assertTrue($pool->save($pool->getItem($uniqId)));
   }

   /**
    * Assert save defered true
    */
   protected function assertSaveDeferedTrue()
   {
       $pool = $this->getCacheItemPool();
       $this->assertTrue($pool->saveDeferred($pool->getItem(uniqid())));
   }

   /**
    * Assert save defered false
    */
   protected function assertSaveDeferedFalse()
   {
       $pool = $this->getCacheItemPool();
       $item = $pool->getItem(uniqid());
       $pool->saveDeferred($item);
       $this->assertFalse($pool->saveDeferred($item));
   }

   /**
    * Assert commit true
    */
   protected function assertCommitTrue()
   {
       $pool = $this->getCacheItemPool();
       $item = $pool->getItem(uniqid());
       $pool->saveDeferred($item);
       $this->assertTrue($pool->commit());
   }

}
