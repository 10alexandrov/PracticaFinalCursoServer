<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiProductoController;
use App\Http\Controllers\Api\ApiUsuarioController;
use App\Http\Controllers\Api\ApiFacturaController;
use App\Http\Controllers\Api\ApiCategoriaController;
use App\Http\Controllers\Api\ApiMercanciaController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('user/logout', [AuthController::class, 'logout']);
   //  Route::middleware(['cors'])->group(function () { Route::post('/usuarios', [ApiUsuarioController::class, 'store']); });

     Route::resource('/productos', ApiProductoController::class)-> names("productos");
     Route::resource('/categorias', ApiCategoriaController::class)-> names("categorias");
     Route::resource('/mercancias', ApiMercanciaController::class)-> names("mercancis");
     Route::resource('/facturas', ApiFacturaController::class)-> names("facturas");
     Route::resource('/estadistica', ApiFacturaController::class)-> names("estadistica");
});

Route::post('user/login', [AuthController::class, 'login']);
Route::resource('/usuarios', ApiUsuarioController::class)->except(['store'])-> names("usuarios");
Route::post('/usuarios', [ApiUsuarioController::class, 'store']);
// Route::resource('/productos', ApiProductoController::class)-> names("productos");
// Route::resource('/mercancias', ApiMercanciaController::class)-> names("mercancis");
// Route::resource('/categorias', ApiCategoriaController::class)-> names("categorias");


