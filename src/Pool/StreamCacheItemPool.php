<?php

namespace Seeren\Cache\Pool;

use Psr\Cache\CacheItemInterface;
use Seeren\Http\Stream\Stream;
use Seeren\Cache\Item\CacheItem;

/**
 * Class to represent a stream cache pool
 *
 *     __
 *    / /__ __ __ __ __ __
 *   / // // // // // // /
 *  /_// // // // // // /
 *    /_//_//_//_//_//_/
 *
 * @package Seeren\Cache\Pool
 */
class StreamCacheItemPool extends AbstractCacheItemPool
{

    /**
     * @var string
     */
    private string $includePath;

    /**
     * @param string|null $includePath
     */
    public function __construct(string $includePath = null)
    {
        $this->includePath = rtrim(
            $includePath ?? dirname(__FILE__, 6)
            . DIRECTORY_SEPARATOR
            . 'var'
            . DIRECTORY_SEPARATOR
            . 'cache',
            DIRECTORY_SEPARATOR
        );
    }

    /**
     * @param string $key
     * @return string $target
     */
    private function getFilename(string $key): string
    {
        $directories = explode('.', $key);
        $target = $this->includePath . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $directories);
        if (!is_file($target)) {
            $path = '';
            array_pop($directories);
            foreach ($directories as $directory) {
                $path .= DIRECTORY_SEPARATOR . $directory;
                if (!is_dir($this->includePath . $path)) {
                    mkdir($this->includePath . $path);
                }
            }
        }
        return $target;
    }

    /**
     * {@inheritDoc}
     * @see AbstractCacheItemPool::create()
     */
    protected function create(string $key): CacheItemInterface
    {
        $serialized = (string)new Stream($this->getFilename($key), Stream::MODE_C_MORE);
        return $serialized ? unserialize($serialized) : new CacheItem($key);
    }

    /**
     * {@inheritDoc}
     * @see AbstractCacheItemPool::persist()
     */
    protected function persist(CacheItemInterface $item): bool
    {
        $stream = new Stream($this->getFilename($item->getKey()), Stream::MODE_W_MORE);
        $stream->write(serialize($item));
        $stream->detach();
        return true;

    }

    /**
     * {@inheritDoc}
     * @see AbstractCacheItemPool::remove()
     */
    protected function remove(CacheItemInterface $item): bool
    {
        $filename = $this->getFilename($item->getKey());
        return is_file($filename) && unlink($filename);
    }

}
