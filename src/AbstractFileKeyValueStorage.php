<?php

namespace Greeflas\Storage;

use Greeflas\Storage\Exception\InvalidConfigException;

abstract class AbstractFileKeyValueStorage implements KeyValueStorageInterface
{
    protected $file;

    abstract protected function load(): array;

    abstract protected function update(array $data): void;

    public function __construct(string $pathToFile)
    {
        if (empty($pathToFile)) {
            throw new InvalidConfigException('You should specify path to file');
        }

        if ('/' === substr($pathToFile, -1, 1)) {
            throw new InvalidConfigException('You should specify path to file, path to directory given');
        }

        if (!\file_exists($pathToFile)) {
            throw new InvalidConfigException('File does not exist, you should create it');
        }

        $this->file = $pathToFile;
    }

    public function set(string $key, $value): void
    {
        $data = $this->load();
        $data[$key] = \is_object($value) ? \serialize($value) : $value;
        $this->update($data);
    }

    public function get(string $key)
    {
        $data = $this->load();

        if (isset($data[$key])) {
            $value = $data[$key];

            if (\is_string($value) && $object = @\unserialize($value)) {
                return $object;
            }

            return $value;
        }

        return null;
    }

    public function has(string $key): bool
    {
        $data = $this->load();

        return isset($data[$key]);
    }

    public function remove(string $key): void
    {
        $data = $this->load();

        if (isset($data[$key])) {
            unset($data[$key]);
            $this->update($data);
        }
    }

    public function clear(): void
    {
        \file_put_contents($this->file, '', \LOCK_EX);
    }
}
