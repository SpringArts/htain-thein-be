<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthServices\AuthService;
use App\UseCases\Auth\UserAgentAction;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
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

    public function redirectToProvider(string $provider, Request $request): RedirectResponse
    {
        $locale = $request->input('locale', 'en'); // Default to 'en' if not provided
        $request->session()->put('locale', $locale); // Store locale in session

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(string $provider, Request $request): RedirectResponse
    {
        $locale = $request->session()->get('locale', 'en');
        $user = Socialite::driver($provider)->stateless()->user();
        $token = $this->authService->handleAuthentication($user, $provider);
        $authUser = getAuthUserOrFail();

        $encryptedUserData = encryptAlgorithm([
            'userId' => $authUser->id,
            'userName' => $authUser->name,
            'userRole' => $authUser->role,
            'token' => $token,
        ]);

        return redirect()->away(config('app.frontend_url').'/'.$locale.'/login?encrypted='.urlencode($encryptedUserData));
    }
}
