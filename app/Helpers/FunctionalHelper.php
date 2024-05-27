<?php

use Illuminate\Support\Facades\Crypt;

if (!function_exists('encryptAlgorithm')) {
    function encryptAlgorithm(array|string $value): string
    {
        $jsonData = json_encode($value);
        if ($jsonData === false) {
            throw new \Exception('Failed to encode value to JSON');
        }
        $encryptedData = Crypt::encryptString($jsonData);

        return $encryptedData;
    }
}
