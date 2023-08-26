<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class UserPolicy
{
    use HandlesAuthorization;

    public function superAdminPermission()
    {
        Log::info(Auth::user()->role . "sdfasad");
        return Auth::user()->role === 'SuperAdmin';
    }

    public function adminPermission()
    {
        Log::info(Auth::user()->role . "aaa");
        return in_array(Auth::user()->role, ['SuperAdmin', 'Admin']);
    }

    public function memberPermission()
    {
        Log::info(Auth::user()->role . "mm");
        return in_array(Auth::user()->role, ['SuperAdmin', 'Admin']);
    }
}
