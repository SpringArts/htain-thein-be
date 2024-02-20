<?php

namespace App\Enums;

enum UserRoleType: string
{
    public const SUPER_ADMIN  = 'SuperAdmin';
    public const ADMIN = 'Admin';
    public const MEMBER = 'Member';
}
