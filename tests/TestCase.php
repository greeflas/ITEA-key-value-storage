<?php

namespace Greeflas\Storage\Tests;

abstract class TestCase
{
    public static function run()
    {
        $test = new static();
        $test->testSet();
        $test->testGet();
        $test->testHas();
        $test->testRemove();
        $test->testClear();
    }

    abstract public function testSet();
    abstract public function testGet();
    abstract public function testHas();
    abstract public function testRemove();
    abstract public function testClear();

    protected function assertEquals($expected, $actual)
    {
        if ($actual === $expected) {
            echo sprintf("%s is OK!\n", __METHOD__);

            return;
        }

        echo \sprintf(
            "%s failed assert that '%s' equals '%s'\n",
            __METHOD__,
            \var_export($expected, true),
            \var_export($actual, true)
        );
    }
}
