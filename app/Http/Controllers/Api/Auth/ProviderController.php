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
        // Set user ID and name as separate cookies
        $userIdCookie = cookie('userId', auth()->user()->id, 60 * 24); // Set cookie to expire in 24 hours
        $userNameCookie = cookie('userName', auth()->user()->name, 60 * 24); // Set cookie to expire in 24 hours
        $tokenCookie = cookie('accessToken', $token, 60 * 24); // Set cookie to expire in 24 hours

        // Redirect to the dashboard page with the cookies
        return redirect()->away(config('app.frontend_url') . '/dashboard')
            ->withCookie($userIdCookie)
            ->withCookie($userNameCookie)
            ->withCookie($tokenCookie);
    }
}
