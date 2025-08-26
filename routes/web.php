<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/loan/application', [PublicController::class, 'step1'])->name('loan.application');
Route::get('loan/application/form', [PublicController::class, 'step2'])->name('loan.application.form');
Route::post('/upload-challan', [PublicController::class, 'uploadChallan'])->name('upload.challan');
Route::get('/application/{id}/print', [PublicController::class, 'printDoc'])->name('application.print');
Route::post('/storeForm', [PublicController::class, 'storeForm'])->name('storeForm');

Route::get('/get-tehsils/{district_id}', [PublicController::class, 'getTehsils'])->name('get.tehsils');
Route::get('/get-subcategories/{category_id}', [PublicController::class, 'getSubcategories'])->name('get.subcategories');
Route::get('/get-branches/{branch_id}', [PublicController::class, 'getBranches'])->name('get.branches');


Route::match(['get', 'post'], '/track-application', [PublicController::class, 'trackView'])->name('track.application');



Route::match(['post', 'get'], '/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    // Route::get('/applicant/list', [\App\Http\Controllers\ApplicantController::class, 'index'])->name('applicant.list');
    Route::resource('/applicant', \App\Http\Controllers\ApplicantController::class);
    Route::post('/applicant/{id}/approve', [\App\Http\Controllers\ApplicantController::class, 'approve'])
        ->name('applicant.Approve');

    Route::post('/applicant/{id}/forward', [\App\Http\Controllers\ApplicantController::class, 'forward'])
        ->name('applicant.forward');

    Route::resource('/user', \App\Http\Controllers\UserContoller::class);

    Route::post('/applicants/{id}/approve', [\App\Http\Controllers\ApplicantController::class, 'approve'])->name('applicants.approve');
    Route::post('/applicants/{id}/forward-to-bank', [\App\Http\Controllers\ApplicantController::class, 'forwardToBank'])->name('applicants.forward');
    Route::post('/applicants/{id}/reject', [\App\Http\Controllers\ApplicantController::class, 'reject'])->name('applicants.reject');

    // ---------------Avtivity Logs----------------------------------------------------------
    Route::get('activity-logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activitylogs.index');
    Route::get('/activity-logs/{id}', [\App\Http\Controllers\ActivityLogController::class, 'show'])->name('activitylogs.show');
    Route::match( ['post', 'get'], '/change/Password', [\App\Http\Controllers\UserContoller::class, 'changePassword'])->name('change.password');

    // ----------------------Ajax Loads------------------------------------------------------
    Route::get('/ajax/gender-quota', [\App\Http\Controllers\AjaxController::class, 'genderQuota'])->name('ajax.gender-quota');
    Route::get('/ajax/tier-quota', [\App\Http\Controllers\AjaxController::class, 'tierQuota'])->name('ajax.tier-quota');


    Route::get('/run-migrations', [MigrationController::class, 'runMigrations']);
    Route::get('/run-composer', [MigrationController::class, 'runComposer']);
});
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');



Route::get('/test-email', [MigrationController::class, 'testEmail']);
Route::get('/config-clear', [MigrationController::class, 'configClear']);
