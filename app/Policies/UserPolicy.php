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
        return Auth::user()->role === 'SuperAdmin';
    }

    public function adminPermission()
    {
        return in_array(Auth::user()->role, ['SuperAdmin', 'Admin']);
    }

    public function memberPermission()
    {
        return in_array(Auth::user()->role, ['SuperAdmin', 'Admin']);
    }
}
