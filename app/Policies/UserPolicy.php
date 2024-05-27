<?php

namespace App\Policies;

use App\Enums\UserRoleType;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function superAdminPermission(): bool
    {
        return getAuthUserOrFail()->role === UserRoleType::SUPER_ADMIN;
    }

    public function adminPermission(): bool
    {
        return in_array(getAuthUserOrFail()->role, [UserRoleType::SUPER_ADMIN, UserRoleType::ADMIN]);
    }

    public function memberPermission(): bool
    {
        return in_array(getAuthUserOrFail()->role, [UserRoleType::SUPER_ADMIN,  UserRoleType::ADMIN]);
    }
}
