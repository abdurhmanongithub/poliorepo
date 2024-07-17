<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CommunityTypeController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DataManagementController;
// use App\Http\Controllers\DataSchemaController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataSchemaController;
use App\Http\Controllers\DataSyncController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\KnowledgeTypeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SmsHistoryController;
use App\Http\Controllers\WeatherDataController;
use App\Http\Controllers\WoredaController;
use App\Http\Controllers\ZoneController;
use App\Models\CommunityType;
use App\Models\Zone;
use RakibDevs\Weather\Weather;
use Spatie\FlareClient\Api;

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

Route::get('/login', [LoginController::class, 'loginView'])->name('login');
Route::post('/login/store', [LoginController::class, 'store'])->name('login.store');
Route::post('logout', [LoginController::class, 'destroy'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {

        return view('base');
    });
    Route::get('/dashboard', [UtilController::class, 'dashboard'])->name('dashboard');
    Route::resource('category', CategoryController::class);
    Route::resource('sub_category', SubCategoryController::class);
    Route::resource('data_schema', DataSchemaController::class);
    Route::post('/users/assign/sub_category', [SubCategoryController::class, 'assignSubCategory'])->name('sub_category.assign_approver');
    Route::post('/users/unassign/sub_category', [SubCategoryController::class, 'unassignSubCategory'])->name('sub_category.unassign_approver');

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
        Route::get('/data/fetch', [DataController::class, 'fetch'])->name('data.fetch');
        Route::get('/data/source', [DataSchemaController::class, 'dataSource'])->name('data.source');
        Route::get('/data/import/view', [DataSyncController::class, 'importView'])->name('data.import.view');
        Route::post('/data/import/excel/preview', [DataSyncController::class, 'syncPreviewFromExcel'])->name('data.sync.preview.excel');
        Route::post('/data/import/excel', [DataSyncController::class, 'syncFromExcel'])->name('data.sync.excel');
        Route::post('/data/import/api', [DataSyncController::class, 'syncFromApi'])->name('data.sync.api');
        Route::post('/data/attribute', [DataSchemaController::class, 'storeAttribute'])->name('attribute.store');
        Route::get('/manage', [DataSchemaController::class, 'manage'])->name('manage');
        Route::get('/data', [DataSchemaController::class, 'dataIndex'])->name('data.index');
        Route::post('/data/attribute', [DataSchemaController::class, 'storeAttribute'])->name('attribute.store');
        Route::post('/export', [DataSchemaController::class, 'exportData'])->name('data.export');
        Route::post('/erase', [DataSchemaController::class, 'eraseData'])->name('data.erase');
        Route::post('/source/{dataSource}/delete', [DataSchemaController::class, 'sourceDelete'])->name('source.delete');
        Route::get('/data/import/template/download', [DataSchemaController::class, 'dataImportTemplateDownload'])->name('import.template.download');
        Route::get('/dashboard_management', [DataSchemaController::class, 'dashboardManagement'])->name('dashboard.management');
        Route::get('/resource_management', [DataSchemaController::class, 'dashboardManagement'])->name('resource.management');
        Route::get('/community', [DataSchemaController::class, 'community'])->name('community.management');
        Route::get('/sms-notification', [DataSchemaController::class, 'sms'])->name('sms.management');
    });
    Route::resource('knowledge-types', KnowledgeTypeController::class);
    Route::resource('knowledge', KnowledgeController::class);
    Route::resource('region', RegionController::class);
    Route::resource('zone', ZoneController::class);
    Route::resource('woreda', WoredaController::class);
    Route::resource('community-type', CommunityTypeController::class);
    Route::resource('community', CommunityController::class);

    Route::resource('sms-history', SmsHistoryController::class);
    Route::get('live-api', [ApiController::class, 'fetchData'])->name('live.index');
    Route::post('live-api', [ApiController::class, 'fetchData'])->name('fetch.data');
    Route::get('custom-sms-create', [SmsHistoryController::class, 'customSmsView'])->name('sms.custom.view');
    Route::post('custom-sms-create/store', [SmsHistoryController::class, 'customSms'])->name('sms.custom.store');
    Route::post('file-import', [SmsHistoryController::class, 'importPhoneNumber'])->name('phonenumber_import');
    Route::post('/import-weather-data', [WeatherDataController::class, 'import'])->name('weather.import');
    Route::resource('weather', WeatherDataController::class);
    Route::get('/get-subcategories-data', [UtilController::class, 'getSubCategoriesData'])->name('getSubCategoriesData');
});


