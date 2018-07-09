<?php

namespace Greeflas\Storage\Tests;

use Greeflas\Storage\JsonKeyValueStorage;
use PHPUnit\Framework\TestCase;

class JsonKeyValueStorageTest extends TestCase
{
    private const STORAGE_FILE = __DIR__ . '/../data/key-value-storage.json';

    /**
     * @var JsonKeyValueStorage
     */
    private $storage;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->storage = new JsonKeyValueStorage(self::STORAGE_FILE);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        \file_put_contents(self::STORAGE_FILE, '', \LOCK_EX);
    }

    /**
     * @expectedException \Greeflas\Storage\Exception\InvalidConfigException
     * @expectedExceptionMessage You should specify path to file
     */
    public function testCreateInstanceWithEmptyFilePath()
    {
        new JsonKeyValueStorage('');
    }

    /**
     * @expectedException \Greeflas\Storage\Exception\InvalidConfigException
     * @expectedExceptionMessage You should specify path to file, path to directory given
     */
    public function createInstanceWithPathToDirectory()
    {
        new JsonKeyValueStorage('/path/to/folder/');
    }

    /**
     * @expectException \Greeflas\Storage\Exception\InvalidConfigException
     * @expectedExceptionMessage File does not exist, you should create it
     */
    public function createInstanceWithNotExistsFile()
    {
        new JsonKeyValueStorage('/path/to/not/exists/file.json');
    }

    public function testSet()
    {
        $this->storage->set('a', 1);
        self::assertEquals(1, $this->storage->get('a'));

        $this->storage->set('a', 2);
        self::assertEquals(2, $this->storage->get('a'));

        $obj = new \stdClass();
        $obj->test = 'data';

        $this->storage->set('obj', $obj);

        self::assertEquals(
            $obj,
            $this->storage->get('obj'),
            'Object should be serialized in the storage'
        );
    }

    public function testGet()
    {
        $expected = [1, 2, 3, 4];
        $this->storage->set('numbers', $expected);

        self::assertSame($expected, $this->storage->get('numbers'));
        self::assertNull($this->storage->get('unknown'));
    }

    public function testHas()
    {
        $this->storage->set('test', '');

        self::assertTrue($this->storage->has('test'));
        self::assertFalse($this->storage->has('unknown'));
    }

    public function testRemove()
    {
        $this->storage->set('test', 123);

        $this->storage->remove('test');
        self::assertFalse($this->storage->has('test'));

        $this->storage->remove('unknown');
    }

    public function testClear()
    {
        $this->storage->set('a', 1);
        $this->storage->set('b', 2);
        $this->storage->set('c', 2);

        $this->storage->clear();

        self::assertFalse($this->storage->has('a'));
        self::assertFalse($this->storage->has('b'));
        self::assertFalse($this->storage->has('c'));
    }
}
