<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\NotiInfoController;
use App\Http\Controllers\Api\AttachmentExportController;
use App\Http\Controllers\Api\GeneralOutcomeController;

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

Route::get('/auth/github', [AuthController::class, 'redirectToGitHub']);
Route::get('/auth/github/callback',  [AuthController::class, 'handleGitHubCallback']);

Route::get('/auth/gmail',  [AuthController::class, 'redirectToGmail']);
Route::get('/auth/gmail/callback',  [AuthController::class, 'handleGmailCallback']);

Route::get('/testing', function () {
    return response()->json([
        'message' => 'Hello World!'
    ]);
});
Route::prefix('app')->middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/reports', ReportController::class);
    Route::apiResource('/noti', NotiInfoController::class);
    Route::apiResource('/general-outcome', GeneralOutcomeController::class);
    Route::get('/all-noti', [NotiInfoController::class, 'fetchAll']);
    Route::get('/uncheck-reports', [ReportController::class, 'uncheckReport']);
    Route::get('/calculations', [ReportController::class, 'calculationFinancial']);
    Route::get('/reports/{report}/reject', [ReportController::class, 'cancelReportHistory']);
    Route::get('/dashboard', [HomeController::class, 'dashboard']);
    Route::put('/reports/{report}/accept',  [ReportController::class, 'acceptReport']);
    Route::post('/user-location', [UserController::class, 'saveLocation']);
    Route::get('/changed-histories', [ReportController::class, 'fetchChangedHistory']);
    Route::post('/contact', [HomeController::class, 'storeContactInfo']);
    Route::get('/user-search', [UserController::class, 'filterUser']);
    Route::get('/report-search', [ReportController::class, 'filterReport']);
    Route::get('/monthly-total', [GeneralOutcomeController::class, 'getMonthlyGeneralOutcome']);
    Route::get('/user-report/{id}', [AttachmentExportController::class, 'userReportExport'])->name('report-export');
});
require __DIR__ . '/auth.php';
