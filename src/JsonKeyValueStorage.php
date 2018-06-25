<?php

namespace Greeflas\Storage;

class JsonKeyValueStorage extends AbstractFileKeyValueStorage
{
    protected function load(): array
    {
        $storage = \file_get_contents($this->file);
        $data = \json_decode($storage, true);

        return \is_array($data) ? $data : [];
    }

    protected function update(array $data): void
    {
        $json = \json_encode($data, \JSON_PRETTY_PRINT);
	    \file_put_contents($this->file, $json, \LOCK_EX);
    }
}
