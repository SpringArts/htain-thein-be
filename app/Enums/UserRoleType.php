<?php

namespace App\Enums;

enum UserRoleType: string
{
    const SUPER_ADMIN  = 'SuperAdmin';
    const ADMIN = 'Admin';
    const MEMBER = 'Member';
}
