<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DataManagementController;
// use App\Http\Controllers\DataSchemaController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataSchemaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;

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


Route::middleware(['guest'])->group(function () {
    Route::get('/dashboard', [UtilController::class, 'dashboard'])->name('dashboard');
    Route::resource('category', CategoryController::class);
    Route::resource('sub_category', SubCategoryController::class);
    Route::resource('data_schema', DataSchemaController::class);

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::get('role/{role}/permission', [RoleController::class, 'permissions'])->name('role.permission.index');
    Route::post('role/{role}/permission', [RoleController::class, 'givePermission'])->name('role.permission.give');
    Route::delete('role/{role}/permission/{permission}', [RoleController::class, 'revokePermission'])->name('role.permission.revoke');
    Route::post('role/{role}/giveAllPermission', [RoleController::class, 'giveAllPermission'])->name('role.giveAllPermission');
    Route::post('role/{role}/removeAllPermission', [RoleController::class, 'removeAllPermission'])->name('role.removeAllPermission');
    Route::group(['prefix' => 'data_schema/{data_schema}', 'as' => 'data_schema.'], function () {
    });
    Route::prefix('data_schema/{data_schema}')->name('data_schema.')->group(function () {
        Route::get('/manage', [DataSchemaController::class, 'manage'])->name('manage');
        Route::get('/data', [DataSchemaController::class, 'dataIndex'])->name('data.index');
        Route::post('/data/attribute', [DataSchemaController::class, 'storeAttribute'])->name('attribute.store');
    });
});


