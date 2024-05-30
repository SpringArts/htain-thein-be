<?php

use App\Http\Controllers\Api\AnnouncementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\NotiInfoController;
use App\Http\Controllers\Api\Auth\ProviderController;
use App\Http\Controllers\Api\GeneralOutcomeController;
use App\Http\Controllers\Api\AttachmentExportController;

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



Route::prefix('app')->middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/reports', ReportController::class);
    Route::apiResource('/notis', NotiInfoController::class);
    Route::apiResource('/announcements', AnnouncementController::class);
    Route::apiResource('/general-outcome', GeneralOutcomeController::class);
    Route::get('/all-notis', [NotiInfoController::class, 'fetchAll']);
    Route::get('/calculations', [ReportController::class, 'calculationFinancial']);
    Route::get('/reports/{report}/reject', [ReportController::class, 'cancelReportHistory']);
    Route::put('/reports/{report}/accept', [ReportController::class, 'acceptReport']);
    Route::get('/uncheck-reports', [ReportController::class, 'uncheckReport']);
    Route::get('/changed-histories/{id}', [ReportController::class, 'fetchChangedHistory']);
    Route::post('/contact', [HomeController::class, 'storeContactInfo']);
    Route::get('/monthly-total', [GeneralOutcomeController::class, 'getMonthlyGeneralOutcome']);
    Route::post('/user-location', [UserController::class, 'saveLocation']);
    Route::get('/user-report/{id}', [AttachmentExportController::class, 'userReportExport'])->name('report-export');

    Route::get('/announcement-batch-delete', [AnnouncementController::class, 'batchDelete']);
    Route::get('/dashboard', [HomeController::class, 'dashboard']);
    Route::get('/message/{receiverId?}', [MessageController::class, 'index']);
    Route::post('/message/{receiverId?}', [MessageController::class, 'store']);

    Route::get('/testing', function () {
        return getAuthUserOrFail();
    });
});
require __DIR__ . '/auth.php';
