<?php

/**
 * This file contain Seeren\Cache\Test\CacheItemPoolInterfaceTest class
 *     __
 *    / /__ __ __ __ __ __
 *   / // // // // // // /
 *  /_// // // // // // /
 *    /_//_//_//_//_//_/
 *
 * @copyright (c) Cyril Ichti <consultant@seeren.fr>
 * @link http://www.seeren.fr/ Seeren
 * @version 1.1.1
 */

namespace Seeren\Cache\Test;

use Psr\Cache\CacheItemPoolInterface;

/**
 * Class for test CacheItemPoolInterface
 * 
 * @category Seeren
 * @package Cache
 * @subpackage Test
 * @abstract
 */
abstract class CacheItemPoolInterfaceTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Get CacheItemPoolInterface
     *
     * @return CacheItemPoolInterface pool
     */
   abstract protected function getCacheItemPoolInterface(): CacheItemPoolInterface;

   /**
    * Test CacheItemPoolInterface InvalidArgumentException
    * 
    * @dataProvider invalidArgumentExceptionProvider
    * @expectedException Psr\Cache\InvalidArgumentException
    */
   public final function testInvalidArgumentException($key)
   {
       $this->getCacheItemPoolInterface()->getItem($key);
   }

   /**
    * InvalidArgumentException provider
    */
   public final function invalidArgumentExceptionProvider()
   {
       return [
           ["foo/bar"],
           ["foo|bar"],
           ["foo-bar"],
           ["foo:bar"],
           ["foo=bar"],
           ["foo[bar]"],
           ["foo{bar}"],
           ["foo(bar)"],
           ["foo&bar"],
       ];
   }

   /**
    * Test CacheItemPoolInterface::getItem
    */
   public final function testGetItem()
   {
       $this->assertFalse(
           $this->getCacheItemPoolInterface()->getItem("testCache")->isHit()
       );
   }

   /**
    * Test CacheItemPoolInterface::getItems
    */
   public final function testGetItems()
   {
       $this->assertTrue(
           count(
               $this->getCacheItemPoolInterface()->getItems(["foo", "bar"])
           ) === 2
       );
   }

   /**
    * Test CacheItemPoolInterface::hasItem
    */
   public final function testHasItem()
   {
       $pool = $this->getCacheItemPoolInterface();
       $pool->getItem("foo");
       $this->assertTrue(
           $pool->hasItem("foo") === true && $pool->hasItem("bar") === false
       );
   }

   /**
    * Test CacheItemPoolInterface::clear
    */
   public final function testClear()
   {
       $pool = $this->getCacheItemPoolInterface();
       $pool->getItems(["foo", "bar"]);
       $this->assertTrue(
           $pool->clear() === true
        && $pool->hasItem("foo") === false
        && $pool->hasItem("bar") === false
       );
   }

   /**
    * Test CacheItemPoolInterface::deleteItem
    */
   public final function testDeleteItem()
   {
       $pool = $this->getCacheItemPoolInterface();
       $pool->getItem("foo");
       $this->assertTrue($pool->deleteItem("foo"));
   }

   /**
    * Test CacheItemPoolInterface::deleteItems
    */
   public final function testDeleteItems()
   {
       $pool = $this->getCacheItemPoolInterface();
         $pool->getItems(["foo", "bar"]);
       $this->assertTrue($pool->deleteItems(["foo", "bar"]));
   }

   /**
    * Test CacheItemPoolInterface::save
    */
   public final function testSave()
   {
       $pool = $this->getCacheItemPoolInterface();
       $item = $pool->getItem("foo");
       $this->assertTrue(
           $pool->save($item) === true
        && $pool->hasItem("foo") === true);
   }

}
