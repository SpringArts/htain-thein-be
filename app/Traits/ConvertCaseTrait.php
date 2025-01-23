<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ConvertCaseTrait
{
    protected function convertKeysToSnakeCase(array $data): array
    {
        $newData = [];
        foreach ($data as $key => $value) {
            $newData[Str::snake($key)] = $value;
        }

        return $newData;
    }
}
