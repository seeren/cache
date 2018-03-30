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
         * @var CacheItemInterface[]
         */
        $pool,
        /**
         * @var CacheItemInterface[]
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
    * @constructor
    */
   protected function __construct()
   {
       $this->pool = [];
       $this->queue = [];
   }

   /**
    * @param string $key
    * @return CacheItemInterface
    */
   protected final function createItem(string $key): CacheItemInterface
   {
       return new CacheItem($key);
   }

   /**
    * {@inheritDoc}
    * @see \Psr\Cache\CacheItemPoolInterface::getItem()
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
    * {@inheritDoc}
    * @see \Psr\Cache\CacheItemPoolInterface::getItems()
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
    * {@inheritDoc}
    * @see \Psr\Cache\CacheItemPoolInterface::hasItem()
    */
   public final function hasItem($key)
   {
       if (!preg_match("/^([A-Za-z0-9_\.]{1,64})$/", $key)) {
           throw new InvalidArgumentException("Invalid key: \"" . $key . "\"");
       }
       return array_key_exists($key, $this->pool);
   }

   /**
    * {@inheritDoc}
    * @see \Psr\Cache\CacheItemPoolInterface::clear()
    */
   public final function clear()
   {
       foreach ($this->pool as $value) {
           if (!$this->poolDeleteItem($value)) {
               return false;
           }
       }
       return true;
   }

   /**
    * {@inheritDoc}
    * @see \Psr\Cache\CacheItemPoolInterface::deleteItem()
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
    * {@inheritDoc}
    * @see \Psr\Cache\CacheItemPoolInterface::deleteItems()
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
    * {@inheritDoc}
    * @see \Psr\Cache\CacheItemPoolInterface::save()
    */
   public final function save(CacheItemInterface $item)
   {
       return $this->poolSave($item);
   }

   /**
    * {@inheritDoc}
    * @see \Psr\Cache\CacheItemPoolInterface::saveDeferred()
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
    * {@inheritDoc}
    * @see \Psr\Cache\CacheItemPoolInterface::commit()
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
