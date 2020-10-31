<?php

namespace Seeren\Cache\Test\Pool;

use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException;
use Seeren\Cache\Pool\StreamCacheItemPool;

class StreamCacheItemPoolTest extends TestCase
{

    /**
     * @return StreamCacheItemPool
     */
    public function getMock(): StreamCacheItemPool
    {
        return new StreamCacheItemPool(__DIR__ . '/../var/cache');
    }

    /**
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::validateKey
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::create
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getFilename
     * @throws InvalidArgumentException
     */
    public function testGetItem(): void
    {
        $mock = $this->getMock();
        $item = $mock->getItem('dummy.foo');
        $this->assertInstanceOf(CacheItemInterface::class, $item);
    }

    /**
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::validateKey
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::create
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getFilename
     * @covers \Seeren\Cache\Exception\InvalidArgumentException::__construct
     */
    public function testGetItemException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->getMock()->getItem('/');
    }

    /**
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItems
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::validateKey
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::create
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getFilename
     * @throws InvalidArgumentException
     */
    public function testGetItems(): void
    {
        $mock = $this->getMock();
        $this->assertCount(2, $mock->getItems(['foo', 'bar']));
    }

    /**
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::validateKey
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::create
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getFilename
     * @throws InvalidArgumentException
     */
    public function testHasItem(): void
    {
        $mock = $this->getMock();
        $mock->getItem('foo');
        $this->assertTrue($mock->hasItem('foo'));
    }

    /**
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Item\CacheItem::getKey
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::clear
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::validateKey
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::create
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getFilename
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::remove
     * @throws InvalidArgumentException
     */
    public function testClear(): void
    {
        $mock = $this->getMock();
        $mock->getItem('foo');
        $this->assertTrue($mock->clear());
    }

    /**
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Item\CacheItem::getKey
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::clear
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::validateKey
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::create
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getFilename
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::remove
     * @throws InvalidArgumentException
     */
    public function testClearFail(): void
    {
        $mock = $this->getMock();
        $mock->getItem('foo');
        $mock->clear();
        $this->assertFalse($mock->clear());
    }

    /**
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Item\CacheItem::getKey
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::validateKey
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::create
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getFilename
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::remove
     * @throws InvalidArgumentException
     */
    public function testDeleteItem(): void
    {
        $mock = $this->getMock();
        $mock->getItem('foo');
        $this->assertTrue($mock->deleteItem('foo'));
    }

    /**
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::validateKey
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::create
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getFilename
     * @throws InvalidArgumentException
     */
    public function testDeleteItemFail(): void
    {
        $mock = $this->getMock();
        $mock->getItem('foo');
        $mock->deleteItem('foo');
        $this->assertFalse($mock->deleteItem('foo'));
    }

    /**
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItems
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItems
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::validateKey
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::create
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getFilename
     * @throws InvalidArgumentException
     */
    public function testDeleteItems(): void
    {
        $mock = $this->getMock();
        $mock->getItems(['foo', 'bar']);
        $this->assertTrue($mock->deleteItems(['foo', 'bar']));
    }

    /**
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::deleteItems
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItems
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::validateKey
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::create
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getFilename
     * @throws InvalidArgumentException
     */
    public function testDeleteItemsFail(): void
    {
        $mock = $this->getMock();
        $mock->getItems(['foo', 'bar']);
        $this->assertFalse($mock->deleteItems(['foo', 'bar', 'baz']));
    }

    /**
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Item\CacheItem::__sleep
     * @covers \Seeren\Cache\Item\CacheItem::getKey
     * @covers \Seeren\Cache\Item\CacheItem::set
     * @covers \Seeren\Cache\Item\CacheItem::__wakeup
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::save
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::validateKey
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::create
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getFilename
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::persist
     * @throws InvalidArgumentException
     */
    public function testSave(): void
    {
        $mock = $this->getMock();
        $item = $mock->getItem('qux');
        $item->set('value');
        $this->assertTrue($mock->save($item));
    }

    /**
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
     * @covers \Seeren\Cache\Item\CacheItem::__wakeup
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::saveDeferred
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::validateKey
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::create
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getFilename
     * @throws InvalidArgumentException
     */
    public function testSaveDeferred(): void
    {
        $mock = $this->getMock();
        $item = $mock->getItem('qux');
        $this->assertTrue($mock->saveDeferred($item));
    }

    /**
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
     * @covers \Seeren\Cache\Item\CacheItem::__wakeup
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::saveDeferred
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::validateKey
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::create
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getFilename
     * @throws InvalidArgumentException
     */
    public function testSaveDeferredFail(): void
    {
        $mock = $this->getMock();
        $item = $mock->getItem('qux');
        $mock->saveDeferred($item);
        $this->assertFalse($mock->saveDeferred($item));
    }

    /**
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::__construct
     * @covers \Seeren\Cache\Item\CacheItem::__sleep
     * @covers \Seeren\Cache\Item\CacheItem::__wakeup
     * @covers \Seeren\Cache\Item\CacheItem::getKey
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::commit
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::getItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::hasItem
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::save
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::saveDeferred
     * @covers \Seeren\Cache\Pool\AbstractCacheItemPool::validateKey
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::create
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::getFilename
     * @covers \Seeren\Cache\Pool\StreamCacheItemPool::persist
     * @throws InvalidArgumentException
     */
    public function testCommit(): void
    {
        $mock = $this->getMock();
        $item = $mock->getItem('qux');
        $mock->saveDeferred($item);
        $this->assertTrue($mock->commit());
    }

}
