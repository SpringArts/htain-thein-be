<?php

namespace App\Policies;

use App\Enums\UserRoleType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function superAdminPermission()
    {
        return Auth::user()->role === UserRoleType::SUPER_ADMIN;
    }

    public function adminPermission()
    {
        return in_array(Auth::user()->role, [UserRoleType::SUPER_ADMIN, UserRoleType::ADMIN]);
    }

    public function memberPermission()
    {
        return in_array(Auth::user()->role, [UserRoleType::SUPER_ADMIN,  UserRoleType::ADMIN]);
    }
}
