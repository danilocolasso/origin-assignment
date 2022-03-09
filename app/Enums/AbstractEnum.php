<?php

namespace App\Enums;

abstract class AbstractEnum
{
    public static function all(): array
    {
        return (new \ReflectionClass(static::class))->getConstants();
    }

    public static function random(): mixed
    {
        $consts = self::all();

        return $consts[array_rand($consts)];
    }
}
