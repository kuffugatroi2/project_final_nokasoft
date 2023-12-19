<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LoginAdminController;
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
Route::get('/admin/login', [LoginAdminController::class, 'show']);

/*---------------------------------------------------ADMIN---------------------------------------------------------------*/

Route::get('/home-page', [HomeController::class, 'home']);
