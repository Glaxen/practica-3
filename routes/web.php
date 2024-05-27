<?php

use App\Http\Controllers\Admin\VehiclesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndependentTables\BrandsController;
use App\Http\Controllers\IndependentTables\BrandsmodelController;
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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/home',[AdminController::class, 'index'])->middleware('auth:sanctum');
Route::get('/filter/brand/{id}',[VehiclesController::class, 'filterModelbyBrand'])->name('filterbybrand')->middleware('auth:sanctum');
Route::resource('/brands', BrandsController::class)->names('admin.brands')->middleware('auth:sanctum');
Route::resource('/brandmodel',BrandsmodelController::class)->names('admin.brandsmodel')->middleware('auth:sanctum');
Route::resource('/vehicles', VehiclesController::class)->names('admin.vehicles')->middleware('auth:sanctum');
