<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Services\AuthServices\AuthService;
use App\UseCases\Auth\UserAgentAction;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProviderController extends Controller
{
    protected AuthService $authService;
    protected UserAgentAction $userAgentAction;

    public function __construct(AuthService $authService, UserAgentAction $userAgentAction)
    {
        $this->authService = $authService;
        $this->userAgentAction = $userAgentAction;
    }

    public function redirectToProvider(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(string $provider): RedirectResponse
    {
        $user = Socialite::driver($provider)->user();
        $token = $this->authService->handleAuthentication($user, $provider);
        $authUser = getAuthUserOrFail();

        $encryptedUserData = encryptAlgorithm([
            'userId' => $authUser->id,
            'userName' => $authUser->name,
            'userRole' => $authUser->role,
            'token' => $token
        ]);
        return redirect()->away(config('app.frontend_url') . '/login?encryptedUserData=' . urlencode($encryptedUserData));
    }
}
