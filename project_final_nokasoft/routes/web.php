<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LoginAdminController;
use App\Http\Controllers\Admin\BrandController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


/*---------------------------------------------------BACKEND---------------------------------------------------------------*/

// Login
Route::get('/admin/login', [LoginAdminController::class, 'show'])->name('login');
Route::post('/login', [LoginAdminController::class, 'login'])->name('admin_authentication.login');
Route::get('/admin/logout', [LoginAdminController::class, 'logout'])->name('admin_authentication.logout');

/*---------------------------------------------------ADMIN---------------------------------------------------------------*/

Route::middleware(['admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/home-page', [HomeController::class, 'home'])->name('admin.home');
        //Brand
        Route::resource('brands', BrandController::class);
        Route::post('/delete-all', [BrandController::class, 'deleteAll'])->name('brands.delete_all');
        Route::get('status-change-brand/{id}', [BrandController::class, 'statusChange'])->name('brands.status_change');
    });
});

