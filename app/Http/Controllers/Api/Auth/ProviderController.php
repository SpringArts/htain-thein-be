<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Services\AuthServices\AuthService;

class ProviderController extends Controller
{
    protected $googleAuthService;


    public function __construct(AuthService $googleAuthService)
    {
        $this->googleAuthService = $googleAuthService;
    }

    public function redirectToGoogle($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleGoogleCallback($provider)
    {

        $user = Socialite::driver($provider)->stateless()->user();
        // Call the handleAuthentication method of googleAuthService
        $token = $this->googleAuthService->handleAuthentication($user, $provider);

        $cookie = cookie('IncomeController', $token, 60 * 24); // 24 hours expiration
        $redirectUrl = env('FRONTEND_URL') . '?userId=' . auth()->user()->id . '&accessToken=' . $token;
        return redirect()->away($redirectUrl)->withCookie($cookie);
    }
}
