<?php

use App\Models\User;

if (!function_exists('getAuthUserOrFail')) {
    function getAuthUserOrFail(): User
    {
        $user = auth('api')->user();
        if (!$user || !($user instanceof User)) {
            throw new \Exception('Invalid user');
        }
        return $user;
    }
}
