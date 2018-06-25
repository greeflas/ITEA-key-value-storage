<?php

namespace Greeflas\Storage\Tests;

use Greeflas\Storage\YamlKeyValueStorage;

class YamlKeyValueStorageTest extends TestCase
{
    private $storage;

    public function __construct()
    {
        $this->storage = new YamlKeyValueStorage(__DIR__ . '/../data/key-value-storage.yaml');
    }

    public function testSet()
    {
        $this->storage->set('date', 'June 25');
        $this->assertEquals('June 25', $this->storage->get('date'));
    }

    public function testGet()
    {
        $this->storage->set('products', [11, 67, 89]);

        $this->assertEquals([11, 67, 89], $this->storage->get('products'));
        $this->assertEquals(null, $this->storage->get('undefined'));
    }

    public function testHas()
    {
        $this->storage->set('version', '2.0-beta');

        $this->assertEquals(true, $this->storage->has('version'));
        $this->assertEquals(false, $this->storage->has('undefined'));
    }

    public function testRemove()
    {
        $this->storage->set('cache_dir', 'var/cache');
        $this->storage->remove('cache_dir');

        $this->assertEquals(false, $this->storage->has('cache_dir'));
    }

    public function testClear()
    {
        $this->storage->set('pi', \pi());
        $this->storage->clear();

        $this->assertEquals(null, $this->storage->get('pi'));
    }
}
