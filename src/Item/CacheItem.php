<?php

/**
 * This file contain Seeren\Cache\Item\CacheItem class
 *     __
 *    / /__ __ __ __ __ __
 *   / // // // // // // /
 *  /_// // // // // // /
 *    /_//_//_//_//_//_/
 *
 * @copyright (c) Cyril Ichti <consultant@seeren.fr>
 * @link http://www.seeren.fr/ Seeren
 * @version 1.0.2
 */

namespace Seeren\Cache\Item;

use Psr\Cache\CacheItemInterface;
use DateInterval;
use DateTime;

/**
 * Class for represent a cache item
 * 
 * @category Seeren
 * @package Cache
 * @subpackage Item
 * @final
 */
final class CacheItem implements CacheItemInterface, ModifiedItemInterface
{

    private
        /**
         * @var string key for the current cache item
         */
        $key,
        /**
         * @var string serialized value
         */
        $value,
        /**
         * @var int request resulte in a cache hit
         */
        $hit,
        /**
         * @var int time to live
        */
        $timeToLive,
        /**
         * @var int last save
        */
        $lastSave,
        /**
         * @var int last modification
        */
        $lastModification;

   /**
    * Construct AbstractCacheItem
    *
    * @param string $key key for the current cache item
    * @return null
    */
   public final function __construct(string $key = null)
   {
       $this->key = $key ? $key : "item";
       $this->hit = false;
       $this->timeToLive = 0;
       $this->lastSave = time();
       $this->last($this->lastSave);
   }

   /**
    * Set or get date of last modification
    *
    * @param int $timeStamp timeStamp of last modification
    * @return string GMT of last modification
    */
   public final function last(int $timeStamp = null): string
   {
       if ($timeStamp) {
           $this->lastModification = gmdate(
               "D, d M Y H:i:s",
               $timeStamp) . " GMT";
       }
       return $this->lastModification;
   }

   /**
    * Get key
    *
    * @return string item key
    */
   public final function getKey()
   {
       return $this->key;
   }

   /**
    * Get
    * 
    * @return mixed|null value corresponding to item's key
    */
   public final function get()
   {
       return $this->value;   
   }

   /**
    * Is hit
    * 
    * @return bool request resulte
    */
   public final function isHit()
   {
       return $this->hit;
   }

   /**
    * Set value
    * @param mixed $value serializable value to be stored
    *
    * @return static The invoked object.
    */
   public final function set($value)
   {
       $this->value = $value;
       return $this;
   }

   /**
    * Set expiration
    *
    * @param \DateTimeInterface|null $expiration
    * @return static item
    */
   public final function expiresAt($expiration)
   {
       $this->timeToLive = $expiration instanceof DateTime
                         ? $expiration->getTimestamp() - time()
                         : (int) $expiration;
       return $this;
   }

   /**
    * Set expiration
    *
    * @param int|\DateInterval|null $time period of time
    * @return static item
    */
   public final function expiresAfter($time)
   {
       $this->timeToLive = $time instanceof DateInterval
                         ? (new DateTime())->add($interval)->getTimestamp()
                         - time()
                         : (int) $time;
       return $this;
   }

   /**
    * Serialize
    * 
    * @return array attribute name collection
    */
   public final function __sleep()
   {
       $this->lastSave = time();
       return [
           "key",
           "hit",
           "timeToLive",
           "lastSave",
           "lastModification",
           "value"
       ];
   }

   /**
    * Unserialize
    *
    * @return array attribute name collection
    */
   public final function __wakeup()
   {
       $this->hit = 0 === $this->timeToLive
                 || $this->lastSave + $this->timeToLive > time()
                  ? true
                  : false;
   }

}
