<?php

use App\Exceptions\CustomErrorException;
use App\Models\User;
use Illuminate\Http\Response;

if (!function_exists('getAuthUserOrFail')) {
    function getAuthUserOrFail(): User
    {
        $user = auth('api')->user();
        if (!$user || !($user instanceof User)) {
            throw new CustomErrorException('Invalid user', Response::HTTP_UNAUTHORIZED);
        }
        return $user;
    }
}
