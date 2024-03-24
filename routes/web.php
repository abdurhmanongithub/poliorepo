<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilController;
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
    return view('base');
});


Route::get('/login', [LoginController::class, 'loginView'])->name('login');
Route::post('/login/store', [LoginController::class, 'store'])->name('login.store');
Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UtilController::class, 'dashboard'])->name('dashboard');
    Route::resource('category', CategoryController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
});
