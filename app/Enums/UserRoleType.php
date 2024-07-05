<?php

namespace App\Enums;

enum UserRoleType: string
{
    public const SUPER_ADMIN = 'SUPER_ADMIN';

    public const ADMIN = 'ADMIN';

    public const MEMBER = 'MEMBER';
}
