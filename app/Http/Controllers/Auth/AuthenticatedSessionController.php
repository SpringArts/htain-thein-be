<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\Auth\LoginRequest;
use App\UseCases\Auth\UserAgentAction;

class AuthenticatedSessionController extends Controller
{
    protected $userAgentAction;

    public function __construct(UserAgentAction $userAgentAction)
    {
        $this->userAgentAction = $userAgentAction;
    }

    public function store(LoginRequest $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            // generate an API token for the authenticated user
            $token = auth()->user()->createToken('authToken')->plainTextToken;
            $cookie = cookie(name: env('APP_NAME'), value: $token, minutes: 60 * 24);

            $this->userAgentAction->storeUserAgent($request);
            // return the token as a response
            return response()->json([
                'userId' => auth()->user()->id,
                'userName' => auth()->user()->name,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
        }
        abort(401, 'Unauthorized');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy()
    {
        Auth::guard('web')->logout();
        auth()->user()->tokens()->delete();        // Revoke all tokens...
        // Clear the access_token cookie
        Cookie::forget(env('APP_NAME'));

        return ResponseHelper::success('Token revoked', null);
    }
}
