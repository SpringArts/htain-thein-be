<?php

use App\Http\Controllers\Api\Auth\ProviderController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/auth/{provider}', [ProviderController::class, 'redirectToProvider']);
Route::get('/auth/callback/{provider}', [ProviderController::class, 'handleProviderCallback']);
Route::get('/verify-token', [AuthController::class, 'verifyToken']);

require __DIR__ . '/auth.php';
