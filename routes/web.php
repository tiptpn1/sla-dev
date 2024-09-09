<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
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

// Master Divisi
Route::group(['prefix' => 'master-bagian', 'as' => 'master-bagian.'], function () {
    Route::get('/', [BagianController::class, 'index'])->name('index');
});


Route::get('/master-bagian/get-data', [BagianController::class, 'getData'])->name('master-bagian.get-data');
Route::get('/master-bagian/get-data/{id}', [BagianController::class, 'getDataById'])->name('master-bagian.get-data-id');
Route::post('/master-bagian/store', [BagianController::class, 'store'])->name('master-bagian.store');
Route::post('/master-bagian/status/{id}', [BagianController::class, 'updateStatus'])->name('master-bagian.update-status');
Route::post('/master-bagian/form/{id}', [BagianController::class, 'updateForm'])->name('master-bagian.update-form');
Route::delete('/master-bagian/delete/{id}', [BagianController::class, 'delete'])->name('master-bagian.delete');

Route::get('admin', [AdminController::class, 'index'])->name('index');
