<?php

/**
 * This file contain Seeren\Cache\AbstractCacheItem class
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

namespace Seeren\Cache\Pool;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\CacheItemInterface;
use Seeren\Cache\Exception\InvalidArgumentException;
use Seeren\Cache\Item\CacheItem;

/**
 * Class for represent a cache item pool
 * 
 * @category Seeren
 * @package Cache
 * @subpackage Pool
 * @abstract
 */
abstract class AbstractCacheItemPool implements CacheItemPoolInterface
{

    private
        /**
         * @var array CacheItemInterface collection
         */
        $pool,
        /**
         * @var array CacheItemInterface collection
         */
        $queue;

    /**
     * Template method get item
     *
     * @param string $key key for which to return the corresponding cache item
     * @return CacheItemInterface the corresponding cache item
     */
    abstract protected function poolGetItem(string $key): CacheItemInterface;

    /**
     * Template method save item
     *
     * @param CacheItemInterface $item cache item to save
     * @return bool if item was successfully persisted
     */
    abstract protected function poolSave(CacheItemInterface $item): bool;

    /**
     * Template method Delete item
     *
     * @param CacheItemInterface $item cache item to delete
     * @return bool if the item was successfully removed
     */
    abstract protected function poolDeleteItem(CacheItemInterface $item): bool;

   /**
    * Construct AbstractCacheItemPool
    *
    * @return null
    */
   protected function __construct()
   {
       $this->pool = [];
       $this->queue = [];
   }

   /**
    * Create item
    * 
    * @param string $key key for which to return the corresponding cache item
    * @return CacheItemInterface item
    */
   protected final function createItem(string $key): CacheItemInterface
   {
       return new CacheItem($key);
   }

   /**
    * Get item
    * 
    * @param string $key key for which to return the corresponding cache item
    * @return CacheItemInterface the corresponding cache item
    * 
    * @throws InvalidArgumentException if the $key string is not legal
    */
   public final function getItem($key)
   {
       try {
           if (!$this->hasItem($key)) {
               $this->pool[$key] = $this->poolGetItem($key);
           }
           return $this->pool[$key];
       } catch (InvalidArgumentException $e) {
           throw $e;
       }
   }

   /**
    * Get items
    * 
    * @param string[] $keys indexed array of keys of items to retrieve
    * @return array|\Traversable traversable collection of cache items
    * 
    * @throws InvalidArgumentException if the $key string is not a legal
    */
   public final function getItems(array $keys = [])
   {
       try {
           $item = [];
           foreach ($keys as $value) {
               $item[$value] = $this->getItem($value);
           }
       } catch (InvalidArgumentException $e) {
           throw $e;
       }
       return $item;
       
   }

   /**
    * Confirms if the cache contains specified cache item
    * 
    * @param string $key key for which to check existence
    * @return bool if item exists in the cache
    * 
    * @throws InvalidArgumentException if the $key string is not a legal
    */
   public final function hasItem($key)
   {
       if (!preg_match("/^([A-Za-z0-9_\.]{1,64})$/", $key)) {
           throw new InvalidArgumentException("Invalid key: \"" . $key . "\"");
       }
       return array_key_exists($key, $this->pool);
   }

   /**
    * Clear
    *
    * @return bool if the pool was successfully cleared
    */
   public final function clear()
   {
       foreach ($this->pool as $key => $value) {
           if (!$this->poolDeleteItem($this->pool[$key])) {
               return false;
           }
       }
       return true;
   }

   /**
    * Delete item
    *
    * @param string $key key to delete
    * @return bool if the item was successfully removed
    * 
    * @throws InvalidArgumentException if the $key string is not a legal
    */
   public final function deleteItem($key)
   {
       try {
           if (!$this->hasItem($key)
            || !$this->poolDeleteItem($this->pool[$key])) {
               return false;
           }
           unset($this->pool[$key]);
       } catch (InvalidArgumentException $e) {
           throw $e;
       }
       return true;
   }

   /**
    * Delete items
    *
    * @param string[] $keys keys that should be removed
    * @return bool if the items were successfully removed
    * 
    * @throws InvalidArgumentException If any of the keys are not a legal
    */
   public final function deleteItems(array $keys)
   {
       try {
           foreach ($keys as $value) {
               if (!$this->deleteItem($value)) {
                   return false;
               }
           }
       } catch (InvalidArgumentException $e) {
           throw $e;
       }
       return true;
   }

   /**
    * Persists a cache item immediately.
    *
    * @param CacheItemInterface $item cache item to save
    *
    * @return bool if item was successfully persisted
    */
   public final function save(CacheItemInterface $item)
   {
       return $this->poolSave($item);
   }

   /**
    * Sets deferred
    *
    * @param CacheItemInterface $item cache item to save
    * @return bool if the item could be queued
    */
   public final function saveDeferred(CacheItemInterface $item)
   {
        if (in_array($item, $this->queue)) {
            return false;
        }
        $this->queue[] = $item;
        return true;
   }

   /**
    * Commit
    *
    * @return bool if all not-yet-saved items were successfully saved
    */
   public final function commit()
   {
       foreach ($this->queue as $key => $value) {
           if (!$this->save($value)) {
               return false;
           }
           unset($this->queue[$key]);
       }
       return true;
   }

}
