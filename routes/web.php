<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterBagianController;
use App\Http\Controllers\UsernameController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\SummaryIndicatorController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('login');
});

Route::get('login', 'App\Http\Controllers\AuthController@login');
Route::post('actionLogin', 'App\Http\Controllers\AuthController@actionLogin')->name('actLogin');
Route::post('logout', 'App\Http\Controllers\AuthController@logout')->name('logout');

Route::group(['prefix' => 'master-username', 'as' => 'master-username.'], function () {
    Route::get('/', [UsernameController::class, 'index'])->name('index');
    Route::get('/get-data', [UsernameController::class, 'getData'])->name('data');
    Route::get('create', [UsernameController::class, 'create'])->name('create');
    Route::post('/store', [UsernameController::class, 'store'])->name('store');
    Route::get('{id}/show', [UsernameController::class, 'show'])->name('show');
    Route::get('{id}/edit', [UsernameController::class, 'edit'])->name('edit');
    Route::get('{id}/data', [UsernameController::class, 'getDataById'])->name('get-data-by-id');
    Route::put('update', [UsernameController::class, 'update'])->name('update');
    Route::delete('destroy/{id}', [UsernameController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'master-role', 'as' => 'master-role.'], function () {
    Route::get('/', [RoleController::class, 'index'])->name('index');
    Route::get('/get-data', [RoleController::class, 'getData'])->name('data');
    Route::get('create', [RoleController::class, 'create'])->name('create');
    Route::post('/store', [RoleController::class, 'store'])->name('store');
    Route::get('{id}/show', [RoleController::class, 'show'])->name('show');
    Route::get('{id}/edit', [RoleController::class, 'edit'])->name('edit');
    Route::get('{id}/data', [RoleController::class, 'getDataById'])->name('get-data-by-id');
    Route::put('update', [RoleController::class, 'update'])->name('update');
    Route::delete('destroy/{id}', [RoleController::class, 'destroy'])->name('destroy');
});

//Dashboard KPI
Route::get('dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
Route::post('dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard.search');
//Route::post('dash_data', 'App\Http\Controllers\DashboardController@dashdata');

//Monitoring KPI
// Route::get('index', 'App\Http\Controllers\DashboardController@mondata');
Route::get('monitoring', [MonitoringController::class, 'index'])->name('monitoring');
Route::post('monitoring', [MonitoringController::class, 'index'])->name('monitoring.search');

//Route::post('/process-form', 'App\Http\Controllers\DashboardController@processForm');

Route::post('monitoring/kpi/update', [MonitoringController::class, 'updateMonitoringKpi'])->name('kpi.monitoring.update');

// Route::post('/kpiekonomi1/update', [DashboardController::class, 'updateKpiEkonomiFinansial'])->name('kpiekonomi1.update');
// Route::post('/kpiekonomi2/update', [DashboardController::class, 'updateKpiEkonomiOperasional'])->name('kpiekonomi2.update');
// Route::post('/kpiekonomi3/update', [DashboardController::class, 'updateKpiEkonomiSosial'])->name('kpiekonomi3.update');
// Route::post('/kpibisnis/update', [DashboardController::class, 'updateKpisnis'])->name('kpibisnis.update');
// Route::post('/kpiteknologi/update', [DashboardController::class, 'updateKpiTeknologi'])->name('kpiteknologi.update');
// Route::post('/kpiinventasi/update', [DashboardController::class, 'updateKpiInventasi'])->name('kpiinventasi.update');
// Route::post('/kpitalenta/update', [DashboardController::class, 'updateKpiTalenta'])->name('kpitalenta.update');
// Route::post('/kpiturunan/update', [DashboardController::class, 'updateKpiTurunan'])->name('kpiturunan.update');

Route::get('/kpi-detail/{id}', [MonitoringController::class, 'getKPIDetail'])->name('kpi.detail');


route::group(['prefix' => 'kpi', 'as' => 'kpi.'], function () {
    Route::get('/', 'App\Http\Controllers\KPIController@index')->name('index');
    Route::get('/get-data', 'App\Http\Controllers\KPIController@getData')->name('data');
    Route::get('create', 'App\Http\Controllers\KPIController@create')->name('create');
    Route::post('/storeKpi', 'App\Http\Controllers\KPIController@storeKpi')->name('storeKpi');
    Route::post('/storeDistribusi', 'App\Http\Controllers\KPIController@storeDistribusi')->name('storeDistribusi');
    Route::get('{id}/edit', 'App\Http\Controllers\KPIController@edit')->name('edit');
    Route::put('{id}/update-kpi', 'App\Http\Controllers\KPIController@updateKpi')->name('updateKpi');
    Route::put('{id}/update-distribusi', 'App\Http\Controllers\KPIController@updateDistribusi')->name('updateDistribusi');
    Route::delete('{id}/destroy', 'App\Http\Controllers\KPIController@destroy')->name('destroy');
    Route::get('{id}/show', 'App\Http\Controllers\KPIController@show')->name('show');
});

Route::get('segment', 'App\Http\Controllers\SegmentController@index')->name('segment.index');
Route::post('segment', 'App\Http\Controllers\SegmentController@store')->name('segment.store');
Route::put('segment/{id}', 'App\Http\Controllers\SegmentController@update')->name('segment.update');
Route::delete('segment/{id}', 'App\Http\Controllers\SegmentController@destroy')->name('segment.destroy');

Route::get('sub-segment', 'App\Http\Controllers\SubSegmentController@index')->name('sub-segment.index');
Route::post('sub-segment', 'App\Http\Controllers\SubSegmentController@store')->name('sub-segment.store');
Route::put('sub-segment/{id}', 'App\Http\Controllers\SubSegmentController@update')->name('sub-segment.update');
Route::delete('sub-segment/{id}', 'App\Http\Controllers\SubSegmentController@destroy')->name('sub-segment.destroy');

Route::post('/upload-file', [MonitoringController::class, 'uploadFile'])->name('upload.file');
Route::get('/download-file/{encrypted}', [MonitoringController::class, 'downloadFile'])->name('download.file');
Route::get('/kpi/files/{id}', [MonitoringController::class, 'getFile'])->name('kpi.file');
Route::delete('/kpi/files/remove/{id}', [MonitoringController::class, 'removeFile'])->name('kpi.file.remove');
Route::post('/download-file/selected', [MonitoringController::class, 'downloadSelectedFile'])->name('download.file.selected');

Route::group(['prefix' => 'master-bagian', 'as' => 'master-bagian.'], function () {
    Route::get('/', [MasterBagianController::class, 'index'])->name('index');
    Route::get('/get-data', [MasterBagianController::class, 'getData'])->name('data');
    Route::get('create', [MasterBagianController::class, 'create'])->name('create');
    Route::post('/store', [MasterBagianController::class, 'store'])->name('store');
    Route::get('{id}/show', [MasterBagianController::class, 'show'])->name('show');
    Route::get('{id}/edit', [MasterBagianController::class, 'edit'])->name('edit');
    Route::get('{id}/data', [MasterBagianController::class, 'getDataById'])->name('get-data-by-id');
    Route::put('update', [MasterBagianController::class, 'update'])->name('update');
    Route::delete('destroy/{id}', [MasterBagianController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'summary-indicator', 'as' => 'summary-indicator.'], function () {
    Route::get('/', [SummaryIndicatorController::class, 'index'])->name('index');
    Route::post('search', [SummaryIndicatorController::class, 'index'])->name('search');
});

