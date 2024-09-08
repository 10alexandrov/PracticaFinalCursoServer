<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiProductoController;
use App\Http\Controllers\Api\ApiUsuarioController;
use App\Http\Controllers\Api\ApiFacturaController;
use App\Http\Controllers\Api\ApiCategoriaController;

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

Route::middleware(['cors'])->group(function () { Route::post('/usuarios', [ApiUsuarioController::class, 'store']); });

Route::resource('/productos', ApiProductoController::class)-> names("productos");
Route::resource('/categorias', ApiCategoriaController::class)-> names("categorias");
Route::resource('/usuarios', ApiUsuarioController::class)-> names("usuarios");
Route::resource('/facturas', ApiFacturaController::class)-> names("facturas");
