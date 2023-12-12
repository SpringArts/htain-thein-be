<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Services\AuthServices\AuthService;

class ProviderController extends Controller
{
    protected $authService;


    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
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

        $cookie = cookie('IncomeController', $token, 60 * 24); // 24 hours expiration
        $redirectUrl = 'http://localhost:3000' . '?userId=' . auth()->user()->id . '&accessToken=' . $token . '&&userName=' . auth()->user()->name;
        return redirect()->away($redirectUrl)->withCookie($cookie);
    }
}
