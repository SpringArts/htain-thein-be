<?php

use App\Exceptions\CustomErrorException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

if (!function_exists('encryptAlgorithm')) {
    function encryptAlgorithm(array|string $value): string
    {
        $jsonData = json_encode($value);
        if ($jsonData === false) {
            throw new CustomErrorException('Failed to encode value to JSON', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $encryptedData = Crypt::encryptString($jsonData);

        return $encryptedData;
    }
}
