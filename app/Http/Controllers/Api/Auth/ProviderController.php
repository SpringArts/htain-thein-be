<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Services\AuthServices\AuthService;
use App\UseCases\Auth\UserAgentAction;

class ProviderController extends Controller
{
    protected $authService;
    protected $userAgentAction;

    public function __construct(AuthService $authService, UserAgentAction $userAgentAction)
    {
        $this->authService = $authService;
        $this->userAgentAction = $userAgentAction;
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {

        $user = Socialite::driver($provider)->stateless()->user();
        // Call the handleAuthentication method of authService
        $token = $this->authService->handleAuthentication($user, $provider);

        $cookie = cookie(name: env('APP_NAME'), value: $token, minutes: 60 * 24);
        $redirectUrl = config('app.frontend_url') . '?userId=' . auth()->user()->id . '&accessToken=' . $token . '&&userName=' . auth()->user()->name;
        return redirect()->away($redirectUrl)->withCookie($cookie);
    }
}
