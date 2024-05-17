<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthorizationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileUpdateController;
use App\Http\Controllers\Admin\CommonController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\DailyPerformanceController;

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

    /*Categories*/
    Route::resource('categories', CategoryController::class);

    /*Employees*/
    Route::resource('employees', EmployeeController::class);

    /*Tasks*/
    Route::resource('tasks', TaskController::class);

    /*Daily Performance*/
    Route::resource('daily-performance', DailyPerformanceController::class);
    Route::get('daily-performance/{id}/list', [DailyPerformanceController::class, 'taskList'])->name('daily-performance.taskList');
    Route::post('daily-performance/{id}', [DailyPerformanceController::class, 'updateTaskData'])->name('daily-performance.update');




    /*Reports*/
    Route::get('reports/category_report', [ReportController::class, 'index_category_report'])->name('reports.category_report');
    Route::get('reports/employee_report', [ReportController::class, 'index_employee_report'])->name('reports.employee_report');
});
