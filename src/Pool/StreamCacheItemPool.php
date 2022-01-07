<?php

namespace Seeren\Cache\Pool;

use Psr\Cache\CacheItemInterface;
use Seeren\Http\Stream\Stream;
use Seeren\Cache\Item\CacheItem;
use Seeren\Http\Stream\StreamInterface;

class StreamCacheItemPool extends AbstractCacheItemPool
{

    private string $includePath;

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

    protected final function create(string $key): CacheItemInterface
    {
        $serialized = (string)new Stream($this->getFilename($key), StreamInterface::MODE_C_MORE);
        return $serialized ? unserialize($serialized) : new CacheItem($key);
    }

    protected final function persist(CacheItemInterface $item): bool
    {
        $stream = new Stream($this->getFilename($item->getKey()), StreamInterface::MODE_W_MORE);
        $stream->write(serialize($item));
        $stream->detach();
        return true;

    }

    protected final function remove(CacheItemInterface $item): bool
    {
        $filename = $this->getFilename($item->getKey());
        return is_file($filename) && unlink($filename);
    }

}
