<?php

use App\Exceptions\CustomErrorException;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

if (! function_exists('getAuthUserOrFail')) {
    function getAuthUserOrFail(): User
    {
        $user = Auth::user();
        if (! $user || ! ($user instanceof User)) {
            throw new CustomErrorException('Invalid user', Response::HTTP_UNAUTHORIZED);
        }

        return $user;
    }
}
