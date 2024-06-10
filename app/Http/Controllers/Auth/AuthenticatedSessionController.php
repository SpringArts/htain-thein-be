<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\UseCases\Auth\UserAgentAction;
use Illuminate\Http\JsonResponse;

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
            // generate an API token for the authenticated user
            $token = $authUser->createToken('authToken')->plainTextToken;

            $this->userAgentAction->storeUserAgent($request);
            // return the token as a response
            return response()->json([
                'userId' => $authUser->id,
                'userName' =>  $authUser->name,
                'userRole' =>  $authUser->role,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
        }
        abort(401, 'Unauthorized');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(): JsonResponse
    {
        $user = getAuthUserOrFail();
        $user->tokens()->delete(); // Revoke all tokens for the user
        Auth::guard('web')->logout(); //need for session logout
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
