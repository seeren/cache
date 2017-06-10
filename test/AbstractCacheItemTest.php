<?php

/**
 * This file contain Seeren\Cache\Test\AbstractCacheItemTest class
 *     __
 *    / /__ __ __ __ __ __
 *   / // // // // // // /
 *  /_// // // // // // /
 *    /_//_//_//_//_//_/
 *
 * @copyright (c) Cyril Ichti <consultant@seeren.fr>
 * @link https://github.com/seeren/cache
 * @version 1.0.1
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
 * @subpackage Test
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
    * Assert gey key
    */
   protected function assertGetKey()
   {
       $this->assertTrue((bool) preg_match(
           "/^([A-Za-z0-9_\.]{1,64})$/",
           $this->getCacheItem()->getKey()));
   }

   /**
    * Assert get
    */
   protected function assertGet()
   {
       $this->assertTrue(null === $this->getCacheItem()->get());
   }

   /**
    * Assert set
    */
   protected function assertSet()
   {
       $item = $this->getCacheItem();
       $value = $this->getCacheItem();
       $item->set($value);
       $this->assertTrue($item->get() === $value);
   }

   /**
    * Assert serialize
    */
   protected function assertSerialize()
   {
       $this->assertTrue(is_string(serialize(
           $this->getCacheItem()->set($this->getCacheItem()))
       ));
   }

   /**
    * Assert unserialize
    */
   protected function assertUnserialize()
   {
       $value = $this->getCacheItem();
       $serialized = serialize($this->getCacheItem()->set($value));
       $this->assertTrue(
           unserialize($serialized)->get()->getKey() === $value->getKey()
       );
   }

   /**
    * Assert is hit false
    */
   protected function assertIsHitFalse()
   {
       $this->assertFalse($this->getCacheItem()->isHit());
   }

   /**
    * Assert is hit true
    */
   protected function assertIsHitTrue()
   {
       $this->assertTrue(unserialize(serialize(
           $this->getCacheItem()))->isHit()
       );
   }

   /**
    * Assert expires after
    */
   protected function assertExpiresAfter()
   {
       $item = $this->getCacheItem();
       $item->expiresAfter(5);
       $item->__wakeup();
       $this->assertTrue($item->isHit());
   }

   /**
    * Assert expires after DateInterval
    */
   protected function assertExpiresAfterDateInterval()
   {
       $item = $this->getCacheItem();
       $item->expiresAfter(new DateInterval("PT2H"));
       $item->__wakeup();
       $this->assertTrue($item->isHit());
   }

   /**
    * Assert last
    */
   protected function assertLast()
   {
       $item = $this->getCacheItem();
       $timeStamp = time();
       $gmt = gmdate("D, d M Y H:i:s", $timeStamp) . " GMT";
       $this->assertTrue($item->last($timeStamp) === $gmt);
   }

   /**
    * Assert expires at
    */
   protected function assertExpiresAt()
   {
       $item = $this->getCacheItem();
       $item->expiresAt(5);
       $item->__wakeup();
       $this->assertTrue($item->isHit());
   }

   /**
    * Assert expires at date
    */
   protected function assertExpiresAtDate()
   {
       $item = $this->getCacheItem();
       $item->expiresAt(new DateTime());
       $item->__wakeup();
       $this->assertTrue($item->isHit());
   }

   /**
    * Assert key
    */
   protected function assertKey()
   {
       $key = "foo";
       $item = $this->getCacheItem();
       $item->__construct($key);
       $this->assertTrue($key === $item->getKey());
   }

   /**
    * Assert __wakeup
    */
   protected function assert__wakeup()
   {
       $item = $this->getCacheItem();
       $item->expiresAt(-3600);
       $item->__wakeup();
       $this->assertFalse($item->isHit());
   }

}
