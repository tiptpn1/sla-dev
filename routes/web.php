<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirektoratController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\MasterBagianController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\ProgressActivityController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RincianProgressController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScopeController;
use App\Http\Controllers\ServerSide\ActivityController as ServerSideActivityController;
use App\Http\Controllers\ServerSide\ProjectScopeController;
use App\Http\Controllers\SubDivisiController;
use App\Http\Controllers\SummaryIndicatorController;
use App\Http\Controllers\UsernameController;
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

Route::redirect('/', 'login');

Route::get('login', [AuthController::class, 'viewLoginPage'])->name('page.login')->middleware('checkLogin');
Route::post('Login', [AuthController::class, 'actionLogin'])->name('login');

Route::middleware(['checkLogin'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

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

    // Master Divisi
    Route::group(['prefix' => 'master-bagian', 'as' => 'master-bagian.'], function () {
        Route::get('/', [BagianController::class, 'index'])->name('index');
        Route::get('get-data', [BagianController::class, 'getData'])->name('get-data');
        Route::get('get-data/{id}', [BagianController::class, 'getDataById'])->name('get-data-id');
        Route::post('store', [BagianController::class, 'store'])->name('store');
        Route::get('{id}/edit', [BagianController::class, 'edit'])->name('edit');
        Route::post('status/{id}', [BagianController::class, 'updateStatus'])->name('update-status');
        Route::post('form/{id}', [BagianController::class, 'updateForm'])->name('update-form');
        Route::put('update/{id}', [BagianController::class, 'update'])->name('update');
        Route::delete('delete/{id}', [BagianController::class, 'delete'])->name('delete');
    });

    // Master Direktorat
    Route::group(['prefix' => 'master-direktorat', 'as' => 'master-direktorat.'], function () {
        Route::get('/', [DirektoratController::class, 'index'])->name('index');
        Route::get('get-data', [DirektoratController::class, 'getData'])->name('get-data');
        Route::get('get-data/{id}', [DirektoratController::class, 'getDataById'])->name('get-data-id');
        Route::post('store', [DirektoratController::class, 'store'])->name('store');
        Route::post('status/{id}', [DirektoratController::class, 'updateStatus'])->name('update-status');
        Route::get('form/{id}', [DirektoratController::class, 'updateForm'])->name('update-form');
        Route::post('form/{id}', [DirektoratController::class, 'updateForm'])->name('update-form');
        Route::delete('delete/{id}', [DirektoratController::class, 'delete'])->name('delete');
    });

    // Master Sub-Divisi 
    Route::group(['prefix' => 'master-sub-divisi', 'as' => 'master-sub-divisi.'], function () {
        Route::get('/', [SubDivisiController::class, 'index'])->name('index');
        Route::get('/get-data', [SubDivisiController::class, 'getData'])->name('data');
        Route::get('create', [SubDivisiController::class, 'create'])->name('create');
        Route::post('/store', [SubDivisiController::class, 'store'])->name('store');
        Route::post('status/{id}', [SubDivisiController::class, 'updateStatus'])->name('update-status');
        Route::get('{id}/show', [SubDivisiController::class, 'show'])->name('show');
        Route::get('{id}/edit', [SubDivisiController::class, 'edit'])->name('edit');
        Route::get('{id}/data', [SubDivisiController::class, 'getDataById'])->name('get-data-by-id');
        Route::put('update/{id}', [SubDivisiController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [SubDivisiController::class, 'destroy'])->name('destroy');
    });

    // Master Project
    Route::group(['prefix' => 'master-proyek', 'as' => 'master-proyek.'], function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('get-data', [ProjectController::class, 'getData'])->name('get-data');
        Route::get('get-data/{id}', [ProjectController::class, 'getDataById'])->name('get-data-id');
        Route::post('store', [ProjectController::class, 'store'])->name('store');
        Route::post('status/{id}', [ProjectController::class, 'updateStatus'])->name('update-status');
        Route::post('form/{id}', [ProjectController::class, 'updateForm'])->name('update-form');
        Route::delete('delete/{id}', [ProjectController::class, 'delete'])->name('delete');
        Route::get('get-data-divisi', [ProjectController::class, 'getDataDivisi'])->name('get-data-divisi');
    });

    // Master Scope
    Route::group(['prefix' => 'master-scope', 'as' => 'master-scope.'], function () {
        Route::get('/', [ScopeController::class, 'index'])->name('index');
        Route::get('get-data', [ScopeController::class, 'getData'])->name('get-data');
        Route::get('get-project-list', [ScopeController::class, 'getProjectList'])->name('get-project-list');
        Route::get('get-subbagian-list/{master_nama_bagian_id}', [ScopeController::class, 'getSubbagianList'])->name('get-subbagian-list');
        Route::get('get-data/{id}', [ScopeController::class, 'getDataById'])->name('get-data-id');
        Route::post('store', [ScopeController::class, 'store'])->name('store');
        Route::post('status/{id}', [ScopeController::class, 'updateStatus'])->name('update-status');
        Route::post('form/{id}', [ScopeController::class, 'updateForm'])->name('update-form');
        Route::delete('delete/{id}', [ScopeController::class, 'delete'])->name('delete');
        Route::get('/get-process/{id}', [ScopeController::class, 'getProcess'])->name('get-process');
    });

    // rincian progress
    Route::prefix('activity/rincian-progress')->name('rincian.')->group(function () {
        Route::get('/{id}', [RincianProgressController::class, 'index'])->name('show');
        Route::post('/get-data', [RincianProgressController::class, 'getData'])->name('getData');
        Route::post('/store', [RincianProgressController::class, 'store'])->name('store');
        Route::put('/update', [RincianProgressController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [RincianProgressController::class, 'delete'])->name('delete');
    });

    // evidence
    Route::prefix('evidence')->name('evidence.')->group(function () {
        Route::post('/get-evidence', [RincianProgressController::class, 'getDataEvidence'])->name('show');
        Route::post('/upload-evidence', [RincianProgressController::class, 'uploadDataEvidence'])->name('upload');
        Route::post('/update-evidence', [RincianProgressController::class, 'updateDataEvidence'])->name('update');
        Route::delete('/delete-evidence', [RincianProgressController::class, 'deleteEvidence'])->name('delete');
        Route::post('/download', [RincianProgressController::class, 'downloadEvidence'])->name('download');;
    });

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('ganchart', [ProgressActivityController::class, 'ganchart'])->name('ganchart');
    Route::get('progress-activity', [ProgressActivityController::class, 'index'])->name('dashboard.progress');

    Route::get('activities/data', [ServerSideActivityController::class, 'data'])->name('activities.data');
    Route::resource('activities', ActivityController::class);
    Route::post('activity/update', [ActivityController::class, 'updateActivity'])->name('activity.update');
    Route::patch('activity/status/{id}', [ActivityController::class, 'updateStatus'])->name('activity.status');

    Route::get('project/data', [ProjectScopeController::class, 'getProjects'])->name('project.data');
    Route::get('project/data/{id}', [ProjectScopeController::class, 'getProjectById'])->name('project.data.detail');
    Route::get('scope/{id}/data', [ProjectScopeController::class, 'getScopes'])->name('scope.data');
    Route::get('scope/data/{id}', [ProjectScopeController::class, 'getScopeById'])->name('scope.data.detail');

    Route::get('dashboard/download-pdf', [DashboardController::class, 'downloadPdf'])->name('dashboard.download-pdf');
    Route::post('dashboard/download-excel', [DashboardController::class, 'downloadExcel'])->name('dashboard.download-excel');
});
