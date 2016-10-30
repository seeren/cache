<?php

/**
 * This file contain Seeren\Cache\Pool\StreamCacheItemPool class
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

namespace Seeren\Cache\Pool;

use Psr\Cache\CacheItemInterface;
use Seeren\Http\Stream\Stream;
use Seeren\Cache\Item\CacheItem;
use InvalidArgumentException;

/**
 * Class for represent a stream cache item pool
 * 
 * @category Seeren
 * @package Cache
 * @subpackage Pool
 */
class StreamCacheItemPool extends AbstractCacheItemPool
{

    private
        /**
         * @var string include path
         */
        $includePath;

    /**
     * Construct AbstractCacheItemPool
     *
     * @param string $includePath include path
     * @return null
     */
    public function __construct(string $includePath = null)
    {
        parent::__construct();
        $this->includePath = ($includePath
                           ? trim($includePath, DIRECTORY_SEPARATOR)
                           : sys_get_temp_dir())
                           . DIRECTORY_SEPARATOR;
    }

    /**
     * Get stream target
     *
     * @param string $key item key
     * @return string target
     */
    private final function getTarget(string $key): string
    {
        $dir = explode(".", $key);
        $file = array_pop($dir);
        $target = implode(DIRECTORY_SEPARATOR, $dir)
                . DIRECTORY_SEPARATOR . $file;
        if (!is_file($target)) {
            $path = "";
            foreach ($dir as $value) {
                $path .= $value . DIRECTORY_SEPARATOR;
                if (!is_dir($this->includePath . $path)) {
                    mkdir($this->includePath . $path);
                }
            }
        }        
        return $target;
    }

    /**
     * Template method get item
     *
     * @param string $key key for which to return the corresponding cache item
     * @return CacheItemInterface the corresponding cache item
     */
    protected final function poolGetItem(string $key): CacheItemInterface
    {
        try {
            $stream = new Stream(
                $this->includePath . $this->getTarget($key),
                Stream::MODE_C_MORE);
            $serialized = $stream->__toString();
            $stream->detach();
            if ($serialized) {
                $item = unserialize($serialized);
                if (is_object($item) && $item instanceof CacheItem) {
                    return $item;
                }
            }
            throw new InvalidArgumentException("Item must implement psr-6");
        } catch (InvalidArgumentException $e) {
            return $this->createItem($key);
        }
    }

    /**
     * Template method save item
     *
     * @param CacheItemInterface $item cache item to save
     * @return bool if item was successfully persisted
     */
    protected final function poolSave(CacheItemInterface $item): bool
    {
        try {
            $stream = new Stream(
                $this->includePath . $this->getTarget($item->getKey()),
                Stream::MODE_W_MORE);
            $stream->write(serialize($item));
            $stream->detach();
            return true;
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    /**
     * Template method Delete item
     *
     * @param CacheItemInterface $item cache item to delete
     * @return bool if the item was successfully removed
     */
    protected final function poolDeleteItem(CacheItemInterface $item): bool
    {
         return is_file($this->includePath . $item->getKey())
             && unlink($this->includePath . $item->getKey());
    }

}
