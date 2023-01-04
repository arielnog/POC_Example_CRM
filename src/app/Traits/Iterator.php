<?php

namespace App\Traits;

trait Iterator
{
    private static function getData(array $data, ...$keys)
    {
        foreach ($keys as $key) {
            if (isset($data[$key])) {
                return $data[$key];
            }
        }

        return null;
    }
}
