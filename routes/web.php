<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthorizationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileUpdateController;
use App\Http\Controllers\Admin\CommonController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ControllerUserController;
use App\Http\Controllers\Admin\CompanyUserController;
use App\Http\Controllers\Admin\CompanyAccountController;
use App\Http\Controllers\Admin\CompanyBranchController;
use App\Http\Controllers\Admin\CompanyTruckController;
use App\Http\Controllers\Admin\CompanyTrailerController;
use App\Http\Controllers\Admin\CompanyDriversController;
use App\Http\Controllers\Admin\ServiceProviderUserController;
use App\Http\Controllers\Admin\ServiceProviderBranchController;
use App\Http\Controllers\Admin\AccountantUserController;
use App\Http\Controllers\Admin\ServiceFeesController;
use App\Http\Controllers\Admin\ServiceProviderAccountController;
use App\Http\Controllers\Admin\ServiceProviderServiceFee;
use App\Http\Controllers\Admin\CompanyCallOutsController;
use App\Http\Controllers\Admin\ControllerClaimController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('admin.login'));
})->middleware(['removePublic']);

Auth::routes();

// ------------------main routes------------------------------------------

Route::get('/admin', [AuthorizationController::class, 'adminLoginForm'])->name('admin.login')->middleware(['removePublic']);
Route::post('/adminLogin', [AuthorizationController::class, 'adminLogin'])->name('admin.signin')->middleware(['removePublic']);

Route::prefix('admin')->middleware(['admin', 'removePublic'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('logout', [AuthorizationController::class, 'adminLogout'])->name('admin.logout');

    /*IMAGE UPLOAD IN SUMMER NOTE*/
    Route::post('image/upload', [ImageController::class,'upload_image']);
    Route::resource('profile_update', ProfileUpdateController::class);

    /*Common*/
    Route::post('common/changestatus', [CommonController::class,'changeStatus'])->name('common.changestatus');

    /*Roles*/
    Route::resource('roles', RoleController::class);

    /*Users*/
    Route::resource('users', UserController::class);

    /* Controllers */
    Route::resource('controllers', ControllerUserController::class);
    Route::get('controllers-claims/service-fees', [ControllerClaimController::class, 'calloutsServiceFees'])->name('controllers-claims.service-fees');
    Route::post('controllers-claims/removeimage', [CompanyCallOutsController::class,'removeImage'])->name('controllers-claims.removeimage');
    Route::resource('controllers-claims', ControllerClaimController::class);
    
    /* Companies */
    Route::resource('companies', CompanyUserController::class);

    /* Companies Accounts */
    Route::resource('companies-accounts', CompanyAccountController::class);

    /* Companies Branches */
    Route::resource('companies-branches', CompanyBranchController::class);

    /* Companies Trucks*/
    Route::resource('companies-trucks', CompanyTruckController::class);

    /* Companies Trailers*/
    Route::resource('companies-trailers', CompanyTrailerController::class);

    /* Companies Drivers*/
    Route::resource('companies-drivers', CompanyDriversController::class);

    /* Companies Call-outs */
    Route::get('companies-call-outs/{companies_call_out}/claimed', [CompanyCallOutsController::class, 'claimed'])->name('call-outs.claimed');
    Route::resource('companies-call-outs', CompanyCallOutsController::class);

    /* Service Provider */
    Route::resource('service-providers', ServiceProviderUserController::class);

    /* Service Provider Branches */
    Route::resource('service-providers-branches', ServiceProviderBranchController::class);

    /* Service Provider Account */
    Route::resource('service-providers-accounts', ServiceProviderAccountController::class);

    /* Accountants */
    Route::resource('accountants', AccountantUserController::class);

    /* Service Fees */
    Route::resource('service-fees', ServiceFeesController::class);

    /* Service Provider Service Fees */
    Route::resource('service-providers-service-fees', ServiceProviderServiceFee::class);
    Route::post('service-providers-service-fees/bulk-update', [ServiceProviderServiceFee::class, 'bulkUpdatePrice'])->name('service-providers-service-fees-bulk-update');

    /*404 Page*/
    Route::get('404', [CommonController::class, 'page_not_found'])->name('errors.404');

    /* AJax*/
    Route::post('users/additional-fields', [CommonController::class,'additionalFieldsForUser'])->name('user.additional_fields');
    Route::post('company-account/branches', [CommonController::class,'getBranchesByAccount'])->name('branches.by_company');
    Route::post('user/accounts', [CommonController::class,'getAccountsByUser'])->name('accounts.by_user');
    Route::post('company/branch/trucks', [CommonController::class,'getTrucksByBranch'])->name('trucks.by_branch');
    Route::post('company/branch/truck/trailers', [CommonController::class,'getTrailerByTrucks'])->name('trailer.by_trucks');
    Route::post('company/branch/truck/drivers', [CommonController::class,'getDriversByTrucks'])->name('driver.by_trucks');
    Route::post('company/drivers', [CommonController::class,'getDriverById'])->name('driver.by_id');
    Route::post('controller/call-out/claim', [CommonController::class,'updateCalloutsStatus'])->name('controller.call-outs.claim');
    Route::post('controller/call-out/assign', [CommonController::class,'updateCalloutsToServiceProviderBranch'])->name('controller.call-outs.assign');
});
