<?php

namespace App\Interfaces\Auth;

use App\Models\LoginLog;

interface UserAgentInterface
{
    public function storeUserAgent(array $userAgentInfo): LoginLog;
}
