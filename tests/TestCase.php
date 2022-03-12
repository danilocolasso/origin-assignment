<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use ReflectionClass;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    final protected function getMockFile(string $filename): array
    {
        $class = new ReflectionClass($this);
        $path = $class->getFilename();
        $path = explode(DIRECTORY_SEPARATOR, $path);
        unset($path[array_key_last($path)]);
        $path = array_merge($path, ['MockFiles', $filename]);

        return json_decode(file_get_contents(implode(DIRECTORY_SEPARATOR, $path)), true);
    }
}
