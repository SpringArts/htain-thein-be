<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\AuthServices\AuthService;
use App\UseCases\Auth\UserAgentAction;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Log;

class ProviderController extends Controller
{
    protected AuthService $authService;

    protected UserAgentAction $userAgentAction;
    protected UserRepository $userRepository;

    public function __construct(AuthService $authService, UserAgentAction $userAgentAction, UserRepository $userRepository)
    {
        $this->authService = $authService;
        $this->userAgentAction = $userAgentAction;
        $this->userRepository = $userRepository;
    }

    public function loginWithOAuth(Request $request): JsonResponse
    {
        $request->validate([
            'access_token' => 'required|string',
            'provider' => 'required|string|in:google,github',
        ]);

        $provider = $request->provider;
        $accessToken = $request->access_token;

        $userDetails = $this->authService->fetchUserDetails($provider, $accessToken);

        if (!$userDetails) {
            return response()->json(['message' => 'Invalid or expired access token'], 401);
        }

        // Find or create the user using the OAuth details
        $user = $this->userRepository->findOrCreateUser($userDetails, $provider);

        // Log in the user and create a Sanctum token
        Auth::login($user);
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'userId' => $user->id,
            'userName' => $user->name,
            'userRole' => $user->role,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
