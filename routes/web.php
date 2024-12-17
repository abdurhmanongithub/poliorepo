<?php

use App\Http\Controllers\AFPDataController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CommunityTypeController;
use App\Http\Controllers\CoreGroupDataController;
use App\Http\Controllers\DashboardController;
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
use App\Http\Controllers\PolioDataPullerController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SmsHistoryController;
use App\Http\Controllers\WeatherDataController;
use App\Http\Controllers\WoredaController;
use App\Http\Controllers\ZoneController;
use App\Models\CommunityType;
use App\Models\CoreGroupData;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;
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
Route::get('/live-dashboard', [UtilController::class, 'liveDashboard'])->name('live.dashboard');

Route::get('/login', [LoginController::class, 'loginView'])->name('login');
Route::post('/login/store', [LoginController::class, 'store'])->name('login.store');
Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/regional-distribution', [DashboardController::class, 'regionalDistribution']);
Route::get('/afp-province-distribution', [DashboardController::class, 'afpProvinceDistribution']);
Route::get('/polio-virus-detection-by-year-chart', [DashboardController::class, 'getPolioVirusDetectionByYear']);
Route::get('/polio-virus-detection-by-year-line-chart', [DashboardController::class, 'getPolioVirusDetectionByYearLineChart']);
Route::get('/polio-emerging-seasons-chart', [DashboardController::class, 'getTopPolioEmergingSeasons']);
Route::get('/polio-emerging-months-chart', [DashboardController::class, 'getTopPolioEmergingMonths']);
Route::get('/polio-virus-distribution-by-gender-chart', [DashboardController::class, 'getPolioVirusDistributionByGender']);
Route::get('/suspected-polio-virus-cell-culturing-results-chart', [DashboardController::class, 'getSuspectedPolioVirusResults']);
Route::get('/polio-cases-by-province', [DashboardController::class, 'getPolioCasesByProvince']);
Route::get('/polio-case-trends', [DashboardController::class, 'getPolioCaseTrends']);
Route::get('/get-timeliness-of-reporting', [DashboardController::class, 'getTimelinessOfReporting']);
Route::get('/afp-polio-virus-detection-by-year-chart', [DashboardController::class, 'getAFPPolioVirusDataDetectionByYear']);
Route::get('/core-group-map-chart',[DashboardController::class,'getGroupedLocations']);
Route::middleware(['auth'])->group(function () {
    Route::get('/polio-data', [PolioDataPullerController::class, 'index'])->name('polio-table.index');
    Route::get('/polio-data/{table}', [PolioDataPullerController::class, 'show'])->name('polio-table.show');
    Route::get('/', function () {

        return redirect()->route('dashboard');
    });
    Route::get('/dashboard', [UtilController::class, 'dashboard'])->name('dashboard');

    Route::resource('category', CategoryController::class);
    Route::resource('sub_category', SubCategoryController::class);
    Route::resource('data_schema', DataSchemaController::class);
    Route::post('/users/assign/sub_category', [SubCategoryController::class, 'assignSubCategory'])->name('sub_category.assign_approver');
    Route::post('/users/unassign/sub_category', [SubCategoryController::class, 'unassignSubCategory'])->name('sub_category.unassign_approver');
    Route::prefix('a-f-p-data')->group(function () {
        Route::get('/', [AFPDataController::class, 'index'])->name('afp-data.index');
        Route::get('/data-management', [AFPDataController::class, 'dataManagement'])->name('afp-data.data-management');
        Route::get('/import/view', [AFPDataController::class, 'importView'])->name('afp-data.import.view');
        Route::post('/excel-import/preview', [AFPDataController::class, 'importPreview'])->name('afp-data.import.preview');
        Route::post('/excel-import/import', [AFPDataController::class, 'import'])->name('afp-data.import');
        Route::get('/data-fetch', [AFPDataController::class, 'datafetch'])->name('afp-data.fetch');
        Route::get('/data/import-template/download', [AFPDataController::class, 'importTemplateDownload'])->name('afp-import.template.download');
        Route::get('/source', [AFPDataController::class, 'dataSource'])->name('afp-data.source');
        Route::post('/source/{source}', [AFPDataController::class, 'dataSourceDelete'])->name('afp-data.source.delete');
        Route::get('/knowledge', [AFPDataController::class, 'content'])->name('afp-data.content');
        Route::post('/knowledge', [AFPDataController::class, 'contentStore'])->name('afp-data.content.store');
        Route::put('/knowledge/{content}', [AFPDataController::class, 'contentUpdate'])->name('afp-data.content.update');
        Route::delete('/knowledge/{content}', [AFPDataController::class, 'contentDelete'])->name('afp-data.content.delete');

    });
    Route::prefix('core-group-data')->group(function () {
        Route::get('/', [CoreGroupDataController::class, 'index'])->name('core-group-data.index');
        Route::get('/data-management', [CoreGroupDataController::class, 'dataManagement'])->name('core-group-data.data-management');
        Route::get('/import/view', [CoreGroupDataController::class, 'importView'])->name('core-group-data.import.view');
        Route::post('/excel-import/preview', [CoreGroupDataController::class, 'importPreview'])->name('core-group-data.import.preview');
        Route::post('/excel-import/import', [CoreGroupDataController::class, 'import'])->name('core-group-data.import');
        Route::get('/data-fetch', [CoreGroupDataController::class, 'datafetch'])->name('core-group-data.fetch');

    });



    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::get('role/{role}/permission', [RoleController::class, 'permissions'])->name('role.permission.index');
    Route::post('role/{role}/permission', [RoleController::class, 'givePermission'])->name('role.permission.give');
    Route::delete('role/{role}/permission/{permission}', [RoleController::class, 'revokePermission'])->name('role.permission.revoke');
    Route::post('role/{role}/giveAllPermission', [RoleController::class, 'giveAllPermission'])->name('role.giveAllPermission');
    Route::post('role/{role}/removeAllPermission', [RoleController::class, 'removeAllPermission'])->name('role.removeAllPermission');
    Route::group(['prefix' => 'data_schema/{data_schema}', 'as' => 'data_schema.'], function () {});
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
    Route::get('/getSubCategoriesExportTrendData', [UtilController::class, 'getSubCategoriesExportTrendData'])->name('getSubCategoriesExportTrendData');
    Route::get('/getSeasonChartData', [UtilController::class, 'getSeasonChartData'])->name('getSeasonChartData');
    Route::get('/fetch-coordinates/{categoryId}', [UtilController::class, 'fetchCoordinates']);
    Route::get('/category-data', [UtilController::class, 'getCategoryDataLineChart']);
    Route::get('/bar-category-data', [UtilController::class, 'getCategoryDataBarChart']);
    Route::get('/view/get-weather', [WeatherDataController::class, 'getWeatherView'])->name('get-weather.view');
    Route::post('/get-weather', [WeatherDataController::class, 'getWeather'])->name('get-weather');
});
