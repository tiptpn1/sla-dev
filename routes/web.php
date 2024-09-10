<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsernameController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\ScopeController;
use App\Http\Controllers\SummaryIndicatorController;

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

// Master Divisi
Route::group(['prefix' => 'master-bagian', 'as' => 'master-bagian.'], function () {
    Route::get('/', [BagianController::class, 'index'])->name('index');
    Route::get('get-data', [BagianController::class, 'getData'])->name('get-data');
    Route::get('get-data/{id}', [BagianController::class, 'getDataById'])->name('get-data-id');
    Route::post('store', [BagianController::class, 'store'])->name('store');
    Route::post('status/{id}', [BagianController::class, 'updateStatus'])->name('update-status');
    Route::post('form/{id}', [BagianController::class, 'updateForm'])->name('update-form');
    Route::delete('delete/{id}', [BagianController::class, 'delete'])->name('delete');
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
});

// Master Scope
Route::group(['prefix' => 'master-scope', 'as' => 'master-scope.'], function () {
    Route::get('/', [ScopeController::class, 'index'])->name('index');
    Route::get('get-data', [ScopeController::class, 'getData'])->name('get-data');
    Route::get('get-project-list', [ScopeController::class, 'getData'])->name('get-project-list');
    Route::get('get-data/{id}', [ScopeController::class, 'getDataById'])->name('get-data-id');
    Route::post('store', [ScopeController::class, 'store'])->name('store');
    Route::post('status/{id}', [ScopeController::class, 'updateStatus'])->name('update-status');
    Route::post('form/{id}', [ScopeController::class, 'updateForm'])->name('update-form');
    Route::delete('delete/{id}', [ScopeController::class, 'delete'])->name('delete');
});



// Route::get('admin', [AdminController::class, 'index'])->name('index');
