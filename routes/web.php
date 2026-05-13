<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserContoller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\PublicController;
use App\Models\User;

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
Route::get('/pmylp', fn() => redirect('/'));
Route::get('/loan/application', [PublicController::class, 'step1'])->name('loan.application');
Route::get('loan/application/form', [PublicController::class, 'step2'])->name('loan.application.form');
Route::post('/upload-challan', [PublicController::class, 'uploadChallan'])->name('upload.challan');
Route::get('/application/{id}/print', [PublicController::class, 'printDoc'])->name('application.print');
Route::get('/application/{id}/challan', [PublicController::class, 'printChallan'])->name('application.challan');
Route::get('/blank/challan', [PublicController::class, 'blankChall'])->name('blank.challan');
Route::post('/storeForm', [PublicController::class, 'storeForm'])->name('storeForm');
Route::post('/submitApplication', [PublicController::class, 'submitApplication'])->name('submitApplication');

Route::get('/get-tehsils/{district_id}', [PublicController::class, 'getTehsils'])->name('get.tehsils');
Route::get('/get-subcategories/{category_id}', [PublicController::class, 'getSubcategories'])->name('get.subcategories');
Route::get('/get-branches/{branch_id}', [PublicController::class, 'getBranches'])->name('get.branches');


Route::match(['get', 'post'], '/track-application', [PublicController::class, 'trackView'])->name('track.application');



Route::match(['post', 'get'], '/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    // Route::get('/applicant/list', [ApplicantController::class, 'index'])->name('applicant.list');
    Route::resource('/applicant', ApplicantController::class);
    // Route::post('/applicant/{id}/approve', [ApplicantController::class, 'approve'])
    //     ->name('applicant.Approve');

    Route::post('/applicant/{id}/forward', [ApplicantController::class, 'forward'])
        ->name('applicant.forward');

    Route::resource('/user', UserContoller::class);

    Route::post('/applicants/{id}/approve', [ApplicantController::class, 'approve'])->name('applicants.approve');
    Route::post('/applicants/{id}/forward-to-bank', [ApplicantController::class, 'forwardToBank'])->name('applicants.forward');
    Route::post('/applicants/{id}/reject', [ApplicantController::class, 'reject'])->name('applicants.reject');
    Route::post('/applicants/{id}/set-unpaid', [ApplicantController::class, 'setUnpaid'])->name('applicants.setUnpaid');
    Route::post('/applicants/{id}/update-challan-date', [ApplicantController::class, 'updateChallanDate'])->name('applicants.updateChallanDate');

    // ---------------Avtivity Logs----------------------------------------------------------
    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activitylogs.index');
    Route::get('/activity-logs/{id}', [ActivityLogController::class, 'show'])->name('activitylogs.show');
    Route::match(['post', 'get'], '/change/Password', [UserContoller::class, 'changePassword'])->name('change.password');

    // ---------------Reports----------------------------------------------------------
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // ---------------Bulk Forward to Bank---------------------------------------------
    Route::post('/applicants/bulk-forward-preview', [ApplicantController::class, 'bulkForwardPreview'])->name('applicants.bulkForwardPreview');
    Route::post('/applicants/bulk-forward', [ApplicantController::class, 'bulkForward'])->name('applicants.bulkForward');
    Route::post('/applicants/bulk-approve-consent-preview', [ApplicantController::class, 'bulkApproveConsentPreview'])->name('applicants.bulkApproveConsentPreview');
    Route::post('/applicants/bulk-approve-consent', [ApplicantController::class, 'bulkApproveConsent'])->name('applicants.bulkApproveConsent');

    // ---------------CSV Import----------------------------------------------------------
    Route::get('/applicants/import', [ApplicantController::class, 'importForm'])->name('applicants.importForm');
    Route::post('/applicants/import', [ApplicantController::class, 'import'])->name('applicants.import');
    Route::get('/applicants/import/sample', [ApplicantController::class, 'downloadSample'])->name('applicants.importSample');

    // ----------------------Ajax Loads------------------------------------------------------
    Route::get('/ajax/gender-quota', [\App\Http\Controllers\AjaxController::class, 'genderQuota'])->name('ajax.gender-quota');
    Route::get('/ajax/tier-quota', [\App\Http\Controllers\AjaxController::class, 'tierQuota'])->name('ajax.tier-quota');


    Route::get('/run-migrations', [MigrationController::class, 'runMigrations']);
    Route::get('/run-composer', [MigrationController::class, 'runComposer']);
    Route::get('/api-token', function () {
        $user = User::firstOrCreate(
            ['email' => 'ajkbankapi@ajk.gov.pk'],
            [
                'name'     => 'Ajk Bank',
                'role_id'  => 4, 
                'password' => bcrypt('StrongDummyPass123!'), 
            ]
        );
        $token = $user->createToken('BankAPI')->plainTextToken;
        return response()->json([
            'token' => $token,
            'message' => 'Use this token in Authorization header as: Bearer <token>'
        ]);
    });
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/test-email', [MigrationController::class, 'testEmail']);
Route::get('/config-clear', [MigrationController::class, 'configClear']);
