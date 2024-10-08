<?php

namespace App\UseCases\Auth;

use App\Interfaces\Auth\UserAgentInterface;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class UserAgentAction
{
    private UserAgentInterface $userAgentRepository;

    public function __construct(UserAgentInterface $userAgentRepository)
    {
        $this->userAgentRepository = $userAgentRepository;
    }

    public function storeUserAgent(Request $request): void
    {
        $agent = new Agent();
        $userAgentString = $request->userAgent();
        $ipAddress = $request->ip(); // Get the IP address of the client

        // Parse the user agent string
        $agent->setUserAgent($userAgentString);
        $agentInfo = [
            'user_agent' => $userAgentString,
            'browser' => $agent->browser(),
            'platform' => $agent->platform(),
            'device' => $agent->device(),
            'ip_address' => $ipAddress, // Include the IP address in the agent info
        ];
        $this->userAgentRepository->storeUserAgent($agentInfo);
    }
}
