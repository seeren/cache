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
 * @see http://www.php-fig.org/psr/psr-6/
 */
class StreamCacheItemPool extends AbstractCacheItemPool
{

    private
        /**
         * @var string include path
         */
        $includePath;

    /**
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
     * @param string $key
     * @return string $target
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
     * {@inheritDoc}
     * @see \Seeren\Cache\Pool\AbstractCacheItemPool::poolGetItem()
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
     * {@inheritDoc}
     * @see \Seeren\Cache\Pool\AbstractCacheItemPool::poolSave()
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
     * {@inheritDoc}
     * @see \Seeren\Cache\Pool\AbstractCacheItemPool::poolDeleteItem()
     */
    protected final function poolDeleteItem(CacheItemInterface $item): bool
    {
         return is_file($this->includePath . $item->getKey())
             && unlink($this->includePath . $item->getKey());
    }

}
