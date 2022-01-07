<?php

namespace Seeren\Cache\Test\Item;

use DateInterval;
use DateTime;
use PHPUnit\Framework\TestCase;
use Seeren\Cache\Item\CacheItem;

class ItemTest extends TestCase
{

    public function getMock(): CacheItem
    {
        return new CacheItem('foo');
    }

    /**
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Item\CacheItem::expiresAfter
     * @covers \Seeren\Cache\Item\CacheItem::last
     */
    public function testLast(): void
    {
        $mock = $this->getMock();
        $mock->expiresAfter(5);
        $this->assertTrue($mock->last() < $mock->last(true));
    }

    /**
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Item\CacheItem::getKey
     */
    public function testGetKey(): void
    {
        $this->assertEquals('foo', $this->getMock()->getKey());
    }

    /**
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Item\CacheItem::get
     */
    public function testGet(): void
    {
        $this->assertNull($this->getMock()->get());
    }

    /**
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Item\CacheItem::isHit
     */
    public function testIsHit(): void
    {
        $this->assertFalse($this->getMock()->isHit());
    }

    /**
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Item\CacheItem::set
     * @covers \Seeren\Cache\Item\CacheItem::get
     */
    public function testSet(): void
    {
        $mock = $this->getMock();
        $mock->set('foo');
        $this->assertEquals('foo', $mock->get());
    }

    /**
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Item\CacheItem::expiresAt
     * @covers \Seeren\Cache\Item\CacheItem::last
     */
    public function testExpiresAt(): void
    {
        $mock = $this->getMock();
        $date = new DateTime();
        $timestamp = $date->getTimestamp();
        $mock->expiresAt($date);
        $this->assertEquals($timestamp, strtotime($mock->last()));
    }

    /**
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Item\CacheItem::expiresAt
     * @covers \Seeren\Cache\Item\CacheItem::last
     */
    public function testExpiresAtDefault(): void
    {
        $mock = $this->getMock();
        $last = $mock->last();
        $mock->expiresAt(null);
        $this->assertEquals($last, $mock->last());
    }

    /**
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Item\CacheItem::expiresAfter
     * @covers \Seeren\Cache\Item\CacheItem::last
     */
    public function testExpiresAfter(): void
    {
        $mock = $this->getMock();
        $last = $mock->last();
        $mock->expiresAfter(5);
        $this->assertTrue(strtotime($last) === strtotime($mock->last()));
    }

    /**
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Item\CacheItem::expiresAfter
     * @covers \Seeren\Cache\Item\CacheItem::last
     */
    public function testExpiresAfterDefault(): void
    {
        $mock = $this->getMock();
        $last = $mock->last();
        $mock->expiresAfter(null);
        $this->assertTrue(strtotime($last) === strtotime($mock->last()));
    }

    /**
     * @covers \Seeren\Cache\Item\CacheItem::__construct
     * @covers \Seeren\Cache\Item\CacheItem::expiresAfter
     * @covers \Seeren\Cache\Item\CacheItem::last
     */
    public function testExpiresAfterInterval(): void
    {
        $mock = $this->getMock();
        $date = new DateInterval('PT3M');
        $last = $mock->last();
        $mock->expiresAfter($date);
        $this->assertEquals(strtotime($last), strtotime($mock->last()));
    }

}
