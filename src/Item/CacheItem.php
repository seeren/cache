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
 * @version 1.0.3
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
 * @see http://www.php-fig.org/psr/psr-6/
 * @final
 */
final class CacheItem implements CacheItemInterface, ModifiedItemInterface
{

    private
        /**
         * @var string
         */
        $key,

        /**
         * @var string
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
    * @param string $key
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
    * {@inheritDoc}
    * @see \Seeren\Cache\Item\ModifiedItemInterface::last()
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
    * {@inheritDoc}
    * @see \Psr\Cache\CacheItemInterface::getKey()
    */
   public final function getKey()
   {
       return $this->key;
   }

   /**
    * {@inheritDoc}
    * @see \Psr\Cache\CacheItemInterface::get()
    */
   public final function get()
   {
       return $this->value;   
   }

   /**
    * {@inheritDoc}
    * @see \Psr\Cache\CacheItemInterface::isHit()
    */
   public final function isHit()
   {
       return $this->hit;
   }

   /**
    * {@inheritDoc}
    * @see \Psr\Cache\CacheItemInterface::set()
    */
   public final function set($value)
   {
       $this->value = $value;
       return $this;
   }

   /**
    * {@inheritDoc}
    * @see \Psr\Cache\CacheItemInterface::expiresAt()
    */
   public final function expiresAt($expiration)
   {
       $this->timeToLive = $expiration instanceof DateTime
                         ? $expiration->getTimestamp() - time()
                         : (int) $expiration;
       return $this;
   }

   /**
    * {@inheritDoc}
    * @see \Psr\Cache\CacheItemInterface::expiresAfter()
    */
   public final function expiresAfter($time)
   {
       $this->timeToLive = $time instanceof DateInterval
                         ? (new DateTime())->add($time)->getTimestamp()
                         - time()
                         : (int) $time;
       return $this;
   }

   /**
    * @return string[]
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
    * @return null
    */
   public final function __wakeup()
   {
       $this->hit = 0 === $this->timeToLive
                 || $this->lastSave + $this->timeToLive > time()
                  ? true
                  : false;
   }

}
