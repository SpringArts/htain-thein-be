<?php

namespace App\Repositories\Auth;

use App\Interfaces\Auth\UserAgentInterface;
use App\Models\LoginLog;

class UserAgentRepository implements UserAgentInterface
{
    public function storeUserAgent(array $userAgentInfo): LoginLog
    {
        return LoginLog::create($userAgentInfo);
    }
}
