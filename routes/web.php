<?php

use App\Http\Controllers\Admin\horario_mantenimientoController;
use App\Http\Controllers\Admin\VehiclesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VehicleoccupantsController;
use App\Http\Controllers\Admin\VehiclerouteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndependentTables\BrandsController;
use App\Http\Controllers\IndependentTables\BrandsmodelController;
use App\Http\Controllers\IndependentTables\UsertypeController;
use App\Http\Controllers\ZonecoordsController;
use App\Http\Controllers\ZonesController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\mantenimientoController;
use App\Http\Controllers\Admin\RoutezoneController;
use App\Http\Controllers\IndependentTables\VehiclecolorController;
use App\Http\Controllers\IndependentTables\VehicletypeController;
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

Route::get('/', [AdminController::class, 'index'])->middleware('auth:sanctum');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/home', [AdminController::class, 'index'])->middleware('auth:sanctum');
Route::get('/filter/brand/{id}', [VehiclesController::class, 'filterModelbyBrand'])->name('filterbybrand')->middleware('auth:sanctum');
Route::get('/filter/usertype/{id}', [VehicleoccupantsController::class, 'filterbyUsertype'])->name('filterbyUsertype')->middleware('auth:sanctum');
Route::get('/filter/vehicleroute', [VehiclerouteController::class, 'filtertable'])->name('filterTableVehicleRoute')->middleware('auth:sanctum');
Route::get('/vehicleroute/multiupdateform', [VehiclerouteController::class, 'showMultiUpdateModal'])->name('showMultiUpdateModal')->middleware('auth:sanctum');
Route::get('/vehicleroute/multiupdate', [VehiclerouteController::class, 'multiUpdate'])->name('multiupdatevehicleroute')->middleware('auth:sanctum');

Route::resource('/colors', VehiclecolorController::class)->names('admin.colors')->middleware('auth:sanctum');

Route::resource('/vehicletype', VehicletypeController::class)->names('admin.vehicletypes')->middleware('auth:sanctum');

Route::resource('/brands', BrandsController::class)->names('admin.brands')->middleware('auth:sanctum');
Route::resource('/brandmodel', BrandsmodelController::class)->names('admin.brandsmodel')->middleware('auth:sanctum');
Route::resource('/vehicles', VehiclesController::class)->names('admin.vehicles')->middleware('auth:sanctum');

Route::resource('/usertypes', UsertypeController::class)->names('admin.usertypes')->middleware('auth:sanctum');
Route::resource('/users', UsersController::class)->names('admin.users')->middleware('auth:sanctum');

Route::resource('/vehicleOccupants', VehicleoccupantsController::class)->names('admin.vehicleoccupants')->middleware('auth:sanctum');

Route::resource('/zones', ZonesController::class)->names('admin.zones')->middleware('auth:sanctum');
Route::resource('/zonescoords', ZonecoordsController::class)->names('admin.zonecoords')->middleware('auth:sanctum');


Route::resource('/vehicleRoutes', VehiclerouteController::class)->names('admin.vehicleroute')->middleware('auth:sanctum');

Route::resource('/routes', RouteController::class)->names('admin.routes');
Route::resource('/routezones', RoutezoneController::class)->names('admin.routezones');
Route::resource('/mantenimiento', mantenimientoController::class)->names('admin.mantenimiento');
Route::resource('/horario_mantenimiento', horario_mantenimientoController::class)->names('admin.horario_mantenimiento');
