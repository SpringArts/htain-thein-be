<?php

namespace App\UseCases\Auth;


use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Interfaces\Auth\UserAgentInterface;

class UserAgentAction
{
    private UserAgentInterface $userAgentRepository;

    public function __construct(UserAgentInterface $userAgentRepository)
    {
        $this->userAgentRepository = $userAgentRepository;
    }


    public function storeUserAgent(Request $request)
    {
        $agent = new Agent();
        $userAgentString = $request->userAgent();

        // Parse the user agent string
        $agent->setUserAgent($userAgentString);
        $agentInfo = [
            'user_agent' => $userAgentString,
            'browser' => $agent->browser(),
            'platform' => $agent->platform(),
            'device' => $agent->device(),
        ];

        $this->userAgentRepository->storeUserAgent($agentInfo);
    }
}
