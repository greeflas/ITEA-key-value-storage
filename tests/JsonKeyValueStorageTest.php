<?php

namespace Greeflas\Storage\Tests;

use Greeflas\Storage\JsonKeyValueStorage;

class JsonKeyValueStorageTest extends TestCase
{
    private $storage;

    public function __construct()
    {
        $this->storage = new JsonKeyValueStorage(__DIR__ . '/../data/key-value-storage.json');
    }

    public function testSet()
    {
        $this->storage->set('date', 'June 24');
        $this->assertEquals('June 24', $this->storage->get('date'));
    }

    public function testGet()
    {
        $this->storage->set('users', [11, 67, 89]);

        $this->assertEquals([11, 67, 89], $this->storage->get('users'));
        $this->assertEquals(null, $this->storage->get('undefined'));
    }

    public function testHas()
    {
        $this->storage->set('version', '1.0-beta');

        $this->assertEquals(true, $this->storage->has('version'));
        $this->assertEquals(false, $this->storage->has('undefined'));
    }

    public function testRemove()
    {
        $this->storage->set('temp_dir', 'var/temp');
        $this->storage->remove('temp_dir');

        $this->assertEquals(false, $this->storage->has('temp_dir'));
    }

    public function testClear()
    {
        $this->storage->set('pi', \pi());
        $this->storage->clear();

        $this->assertEquals(null, $this->storage->get('pi'));
    }
}
