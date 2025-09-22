<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\BankApplicationController;
use App\Http\Controllers\UserContoller;
use Illuminate\Http\Request;
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
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('bank/applications', [BankApplicationController::class, 'index']);
    Route::post('bank/applications/status-update', [BankApplicationController::class, 'bulkUpdate']);
    Route::post('bank/applications/{id}/status-update', [BankApplicationController::class, 'singleUpdate']);
});
Route::middleware('auth:sanctum')->post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');