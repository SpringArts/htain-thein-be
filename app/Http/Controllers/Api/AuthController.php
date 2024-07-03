<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //TODO Refactor
    public function verifyToken(Request $request): JsonResponse
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token not provided'], 400);
        }

        $checkToken = DB::table('personal_access_tokens')
            ->where('token', $token)
            ->first();

        if ($checkToken) {
            return response()->json(['message' => 'Token is valid'], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
