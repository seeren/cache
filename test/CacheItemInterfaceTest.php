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

/**
 * Class for test CacheItemInterface
 * 
 * @category Seeren
 * @package Cache
 * @subpackage Test
 * @abstract
 */
abstract class CacheItemInterfaceTest extends \PHPUnit_Framework_TestCase
{

   /**
    * Get CacheItemInterface
    * 
    * @return CacheItemInterface cache
    */
   abstract protected function getCacheItemInterface(): CacheItemInterface;

   /**
    * Test CacheItemInterface::getKey
    */
   public final function testGetKey()
   {
       $this->assertTrue((bool) preg_match(
           "/^([A-Za-z0-9_\.]{1,64})$/",
           $this->getCacheItemInterface()->getKey()));
   }

   /**
    * Test CacheItemInterface::get
    */
   public final function testGet()
   {
       $this->assertTrue(null === $this->getCacheItemInterface()->get());
   }

   /**
    * Test CacheItemInterface::get
    */
   public final function testSet()
   {
       $item = $this->getCacheItemInterface();
       $value = $this->getCacheItemInterface();
       $item->set($value);
       $this->assertTrue($item->get() === $value);
   }

   /**
    * Test CacheItemInterface serialization
    */
   public final function testSerialize()
   {
       $this->assertTrue(is_string(serialize(
           $this->getCacheItemInterface()->set($this->getCacheItemInterface()))
       ));
   }

   /**
    * Test CacheItemInterface unserialization
    */
   public final function testUnserialize()
   {
       $value = $this->getCacheItemInterface();
       $serialized = serialize($this->getCacheItemInterface()->set($value));
       $this->assertTrue(
           unserialize($serialized)->get()->getKey() === $value->getKey()
       );
   }

   /**
    * Test CacheItemInterface::isHit false
    */
   public final function testIsHitFalse()
   {
       $this->assertFalse($this->getCacheItemInterface()->isHit());
   }

   /**
    * Test CacheItemInterface::isHit true
    */
   public final function testIsHitTrue()
   {
       $this->assertTrue(unserialize(serialize(
           $this->getCacheItemInterface()))->isHit()
       );
   }

}
