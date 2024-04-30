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
        $token = $this->authService->handleAuthentication($user, $provider);
        $authUser = auth()->user();

        $encryptedUserData = encryptAlgorithm([
            'userId' => $authUser->id,
            'userName' => $authUser->name,
            'userRole' => $authUser->role,
            'token' => $token
        ]);
        return redirect()->away(config('app.frontend_url') . '/login?&encryptedUserData=' . urlencode($encryptedUserData));
    }
}
