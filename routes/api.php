<?php

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
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('/verify-otp', [\App\Http\Controllers\AuthController::class, 'verifyOtp']);
Route::post('/resend-otp', [\App\Http\Controllers\AuthController::class, 'resendOtp']);
Route::post('/addlocation',[\App\Http\Controllers\LocationController::class, 'store'])->name('addlocation');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('users', \App\Http\Controllers\UserContoller::class);
    Route::resource('tours', \App\Http\Controllers\TourController::class);
    Route::post('tours/status/{id}/update', [\App\Http\Controllers\TourController::class, 'statusUpdate']);
    Route::get('/location/tpo', [\App\Http\Controllers\LocationController::class, 'locationtpo']);
    Route::get('/settings', [\App\Http\Controllers\AllDataController::class, 'allData'])->name('settings');
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('/news', \App\Http\Controllers\NewsController::class);
    Route::apiResource('/tokens', \App\Http\Controllers\NotificationTokenController::class);
    Route::apiResource('/news', \App\Http\Controllers\NewsController::class);
});
Route::middleware('auth:sanctum')->post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::resource('test-tours', \App\Http\Controllers\TourController::class);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');