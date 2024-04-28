<?php

use Illuminate\Support\Facades\Crypt;

if (!function_exists('encryptAlgorithm')) {
    function encryptAlgorithm(array|string $value): string
    {
        $jsonData = json_encode($value);

        $encryptedData = Crypt::encryptString($jsonData);

        return $encryptedData;
    }
}
