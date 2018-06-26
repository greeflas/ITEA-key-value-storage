Key Value Storage
=================

[![Key Value Storage](https://img.shields.io/badge/PHP%20Advanced-ITEA-red.svg)](#key-value-storage)

This is simple implementation of Key-Value storage. Library provides implementation of
in memory storage, Json file storage and Yaml file storage.

Usage
-----

1. Create storage instance

```php
$storage = new \Greeflas\Storage\InMemoryKeyValueStorage();
```

2. Manipulate with data

```php
$storage->set('db_name', 'app_prod');

$databaseName = $storage->get('db_name') ?? 'app_dev';

if ($storage->has('db_name')) {
    $storage->remove('db_name');
}

$storage->clear();
```

Tests
-----

You can run tests for each storage implementation with following command

`$ ./bin/tests <storage-type>`

available types:

- `in-memory`
- `json`
- `yaml`

example

`$ ./bin/tests json`
