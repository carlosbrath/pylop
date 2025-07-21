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
Route::get('/', function () {
    // return view('welcome');

    return  Redirect::to('login');
});

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/loan/application', [PublicController::class, 'step1'])->name('loan.application');
Route::get('loan/application/form', [PublicController::class, 'step2'])->name('loan.application.form');
Route::post('/upload-challan', [PublicController::class, 'uploadChallan'])->name('upload.challan');
Route::get('/application/{id}/print', [PublicController::class, 'print'])->name('application.print');
Route::post('/storeForm', [PublicController::class, 'storeForm'])->name('storeForm');

Route::get('/get-tehsils/{district_id}', [PublicController::class, 'getTehsils'])->name('get.tehsils');
Route::get('/get-subcategories/{category_id}', [PublicController::class, 'getSubcategories'])->name('get.subcategories');
Route::get('/get-branches/{branch_id}', [PublicController::class, 'getBranches'])->name('get.branches');


Route::match(['get', 'post'], '/track-application', [PublicController::class, 'trackView'])->name('track.application');



Route::match(['post', 'get'], '/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('/news', \App\Http\Controllers\NewsController::class);
    Route::resource('/entrypoints', \App\Http\Controllers\EntryPointOfficeController::class);
    Route::resource('/tour', \App\Http\Controllers\TourController::class);
    Route::get('tours/tourist', [\App\Http\Controllers\TourController::class, 'tourist'])->name('tours.tourist');
    Route::resource('/user', \App\Http\Controllers\UserContoller::class);
    Route::put('/change/{id}/password/', [\App\Http\Controllers\UserContoller::class, 'changePassword'])->name('change.password');
    Route::get('/operators/list', [\App\Http\Controllers\UserContoller::class, 'operators'])->name('operators.list');
    Route::get('/operators/create', [\App\Http\Controllers\UserContoller::class, 'create_operators'])->name('operators.create');
    Route::get('/vehicals/list', [\App\Http\Controllers\AdminController::class, 'vehicals'])->name('vehicals.list');
    Route::resource('/tokens', \App\Http\Controllers\NotificationTokenController::class);
    Route::get('/insertTokens', [\App\Http\Controllers\NotificationTokenController::class, 'insertTokens']);
    Route::get('/run-migrations', [MigrationController::class, 'runMigrations']);
});

Route::get('/test-email', [MigrationController::class, 'testEmail']);
Route::get('/config-clear', [MigrationController::class, 'configClear']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
