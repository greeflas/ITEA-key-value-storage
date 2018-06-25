<?php

namespace Greeflas\Storage\Tests;

use Greeflas\Storage\InMemoryKeyValueStorage;

class InMemoryKeyValueStorageTest extends TestCase
{
    private $storage;

    public function __construct()
    {
        $this->storage = new InMemoryKeyValueStorage();
    }

    public function testSet()
    {
        $this->storage->set('time', '17:00');
        $this->assertEquals('17:00', $this->storage->get('time'));

        $this->storage->set('time', '18:01');
        $this->assertEquals('18:01', $this->storage->get('time'));
    }

    public function testGet()
    {
        $this->storage->set('answers', [11, 67, 89]);

        $this->assertEquals([11, 67, 89], $this->storage->get('answers'));
        $this->assertEquals(null, $this->storage->get('undefined'));
    }

    public function testHas()
    {
        $this->storage->set('version', '3.0-beta');

        $this->assertEquals(true, $this->storage->has('version'));
        $this->assertEquals(false, $this->storage->has('undefined'));
    }

    public function testRemove()
    {
        $this->storage->set('logs_dir', 'var/logs');
        $this->storage->remove('logs_dir');

        $this->assertEquals(false, $this->storage->has('logs_dir'));
    }

    public function testClear()
    {
        $this->storage->set('pi', \pi());
        $this->storage->clear();

        $this->assertEquals(null, $this->storage->get('pi'));
    }
}
