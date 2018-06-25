<?php

namespace Greeflas\Storage;

use Symfony\Component\Yaml\Yaml;

class YamlKeyValueStorage extends AbstractFileKeyValueStorage
{
    protected function load(): array
    {
        $data = Yaml::parseFile($this->file);

        return \is_array($data) ? $data : [];
    }

    protected function update(array $data): void
    {
        $yaml = Yaml::dump($data);
        \file_put_contents($this->file, $yaml, \LOCK_EX);
    }
}
