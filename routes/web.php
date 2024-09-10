<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterBagianController;
use App\Http\Controllers\UsernameController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MonitoringController;
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

//Master Divisi
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

Route::get('admin', [AdminController::class, 'index'])->name('index');
