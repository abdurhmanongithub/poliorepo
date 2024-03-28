<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DataManagementController;
// use App\Http\Controllers\DataSchemaController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UtilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataSchemaController;

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

Route::middleware(['guest'])->group(function () {
    Route::get('/dashboard', [UtilController::class, 'dashboard'])->name('dashboard');
    Route::resource('category', CategoryController::class);
    Route::resource('sub_category', SubCategoryController::class);
    Route::resource('data_schema', DataSchemaController::class);
    Route::group(['prefix' => 'data_schema/{data_schema}', 'as' => 'data_schema.'], function () {
    });
    Route::prefix('data_schema/{data_schema}')->name('data_schema.')->group(function () {
        Route::get('/manage', [DataSchemaController::class,'manage'])->name('manage');
        Route::post('/manage/attribute/add', [DataSchemaController::class,'addAttribute'])->name('attribute.add');
    });
});
