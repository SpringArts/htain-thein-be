<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGitHubCallback()
    {
        $user = Socialite::driver('github')->user();

        // Handle user data and generate a JWT token for API access
        $token = auth()->login($user);

        return redirect(env('FRONTEND_URL') . '/github-login?token=' . $token);
    }

    public function redirectToGmail()
    {
        return Socialite::driver('gmail')->stateless()->redirect();
    }

    public function handleGmailCallback()
    {
        $user = Socialite::driver('gmail')->stateless()->user();

        // Handle user data and generate a JWT token for API access
        $token = auth()->login($user);

        return response()->json(['token' => $token]);
    }
}
