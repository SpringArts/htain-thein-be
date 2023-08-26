<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            // generate an API token for the authenticated user
            $token = auth()->user()->createToken('authToken')->plainTextToken;
            $cookie = cookie(name: 'IncomeController', value: $token, minutes: 60 * 24);
            // return the token as a response
            return ResponseHelper::success('Login Successfully', [
                'userId' => auth()->user()->id,
                'userName' => auth()->user()->name,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ])->withCookie($cookie);
        }
        return ResponseHelper::fail('Login Failed', null);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy()
    {
        Auth::guard('web')->logout();
        auth()->user()->tokens()->delete();        // Revoke all tokens...
        // Clear the access_token cookie
        $cookie = Cookie::forget('IncomeController');

        return ResponseHelper::success('Token revoked', null)->withCookie($cookie);
    }
}
