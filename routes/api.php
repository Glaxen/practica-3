<?php

use App\Http\Controllers\API\UserContoller;
use App\Http\Controllers\API\ZonesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/// ESTA RUTAS SON CONSULTADAS POR EL APLICATIVO MOVIL
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});
//Route::post('api/login', [UserController::class,'login']);
Route::post('/login',[UserContoller::class, 'login']);
Route::get('/askzones',[ZonesController::class, 'index']);
Route::get('/allroutes',[ZonesController::class, 'allroutes2'])->middleware('auth:sanctum');;
Route::post('/register', [UserContoller::class, 'register'])->middleware('api');
Route::post('/logout',[UserContoller::class, 'logout'])->middleware('auth:sanctum');
