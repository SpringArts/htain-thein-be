<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AccountType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\UseCases\Auth\UserAgentAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    protected UserAgentAction $userAgentAction;

    public function __construct(UserAgentAction $userAgentAction)
    {
        $this->userAgentAction = $userAgentAction;
    }

    public function store(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $authUser = getAuthUserOrFail();
            if ($authUser->account_status !== AccountType::ACTIVE) {
                return response()->json(['message' => 'Your account is ' . AccountType::SUSPENDED . '.Please contact to Admin .'], 403);
            }
            // generate an API token for the authenticated user
            $token = $authUser->createToken('api-token')->plainTextToken;

            $this->userAgentAction->storeUserAgent($request);
            $authUser = getAuthUserOrFail();
            // return the token as a response
            return response()->json([
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => $authUser->makeHidden(['password', 'remember_token']),
            ]);
        }

        return response()->json(['message' => 'Your credentials is incorrect'], 403);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(): JsonResponse
    {
        $user = getAuthUserOrFail();
        $user->tokens()->delete(); // Revoke all tokens for the user
        Auth::guard('web')->logout();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
