<?php

namespace Greeflas\Storage\Tests;

use Greeflas\Storage\InMemoryKeyValueStorage;
use Greeflas\Storage\KeyValueStorageInterface;
use PHPUnit\Framework\TestCase;

class InMemoryKeyValueStorageTest extends TestCase
{
    /**
     * @var KeyValueStorageInterface
     */
    private $storage;

    protected function setUp()
    {
        $this->storage = new InMemoryKeyValueStorage();
    }

    public function testSet()
    {
        $this->storage->set('test', 'data');

        $this->assertEquals('data', $this->storage->get('test'));
    }

    public function testGet()
    {
        $this->storage->set('test', 'data');

        $this->assertEquals('data', $this->storage->get('test'));
        $this->assertNull($this->storage->get('unknown'));
    }

    public function testHas()
    {
        $this->storage->set('test', 'data');

        $this->assertTrue($this->storage->has('test'));
        $this->assertFalse($this->storage->has('unknown'));
    }

    /**
     * @dataProvider removeDataProvider
     */
    public function testRemove($key, $data)
    {
        $this->storage->set($key, $data);

        $this->storage->remove($key);

        $this->assertFalse($this->storage->has($key));
    }

    public function testClear()
    {
        $this->storage->set('first', 1);
        $this->storage->set('second', 2);
        $this->storage->set('third', 3);

        $this->storage->clear();

        $this->assertFalse($this->storage->has('first'));
        $this->assertFalse($this->storage->has('second'));
        $this->assertFalse($this->storage->has('third'));
    }

    public function removeDataProvider()
    {
        /*return [
            ['a', 1],
            ['b', 2],
            ['c', 3],
        ];*/

        yield ['a', 1];
        yield ['b', 2];
        yield ['c', 3];
    }
}
