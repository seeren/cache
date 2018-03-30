<?php

/**
 *     __
 *    / /__ __ __ __ __ __
 *   / // // // // // // /
 *  /_// // // // // // /
 *    /_//_//_//_//_//_/
 *
 * @author (c) Cyril Ichti <consultant@seeren.fr>
 * @link https://github.com/seeren/cache
 * @version 1.0.2
 */

namespace Seeren\Cache\Test;

use Psr\Cache\CacheItemInterface;
use DateInterval;
use DateTime;

/**
 * Class for test CacheItemInterface
 * 
 * @category Seeren
 * @package Cache
 * @subpackage Test\Item
 * @abstract
 */
abstract class AbstractCacheItemTest extends \PHPUnit\Framework\TestCase
{

   /**
    * Get CacheItemInterface
    * 
    * @return CacheItemInterface cache
    */
   abstract protected function getCacheItem(): CacheItemInterface;

   /**
    * Test gey key
    */
   public function testGetKey()
   {
       $this->assertTrue((bool) preg_match(
           "/^([A-Za-z0-9_\.]{1,64})$/",
           $this->getCacheItem()->getKey()));
   }

   /**
    * Test get
    */
   public function testGet()
   {
       $this->assertTrue(null === $this->getCacheItem()->get());
   }

   /**
    * Test set
    */
   public function testSet()
   {
       $item = $this->getCacheItem();
       $value = $this->getCacheItem();
       $item->set($value);
       $this->assertTrue($item->get() === $value);
   }

   /**
    * Test serialize
    */
   public function testSerialize()
   {
       $this->assertTrue(is_string(serialize(
           $this->getCacheItem()->set($this->getCacheItem()))
       ));
   }

   /**
    * Test unserialize
    */
   public function testUnserialize()
   {
       $value = $this->getCacheItem();
       $serialized = serialize($this->getCacheItem()->set($value));
       $this->assertTrue(
           unserialize($serialized)->get()->getKey() === $value->getKey()
       );
   }

   /**
    * Test is hit false
    */
   public function testIsHitFalse()
   {
       $this->assertFalse($this->getCacheItem()->isHit());
   }

   /**
    * Test is hit true
    */
   public function testIsHitTrue()
   {
       $this->assertTrue(unserialize(serialize(
           $this->getCacheItem()))->isHit()
       );
   }

   /**
    * Test expires after
    */
   public function testExpiresAfter()
   {
       $item = $this->getCacheItem();
       $item->expiresAfter(5);
       $item->__wakeup();
       $this->assertTrue($item->isHit());
   }

   /**
    * Test expires after DateInterval
    */
   public function testExpiresAfterDateInterval()
   {
       $item = $this->getCacheItem();
       $item->expiresAfter(new DateInterval("PT2H"));
       $item->__wakeup();
       $this->assertTrue($item->isHit());
   }

   /**
    * Test last
    */
   public function testLast()
   {
       $item = $this->getCacheItem();
       $timeStamp = time();
       $gmt = gmdate("D, d M Y H:i:s", $timeStamp) . " GMT";
       $this->assertTrue($item->last($timeStamp) === $gmt);
   }

   /**
    * Test expires at
    */
   public function testExpiresAt()
   {
       $item = $this->getCacheItem();
       $item->expiresAt(5);
       $item->__wakeup();
       $this->assertTrue($item->isHit());
   }

   /**
    * Test expires at date
    */
   public function testExpiresAtDate()
   {
       $item = $this->getCacheItem();
       $item->expiresAt(new DateTime());
       $item->__wakeup();
       $this->assertTrue($item->isHit());
   }

   /**
    * Test key
    */
   public function testKey()
   {
       $key = "foo";
       $item = $this->getCacheItem();
       $item->__construct($key);
       $this->assertTrue($key === $item->getKey());
   }

   /**
    * Test __wakeup
    */
   public function test__wakeup()
   {
       $item = $this->getCacheItem();
       $item->expiresAt(-3600);
       $item->__wakeup();
       $this->assertFalse($item->isHit());
   }

}
