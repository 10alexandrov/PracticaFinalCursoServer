<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\FacturaController;
use App\Http\Controllers\Api\CategoriaController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/productos', ProductoController::class)-> names("productos");
Route::resource('/categorias', CategoriaController::class)-> names("categorias");
Route::resource('/usuarios', UsuarioController::class)-> names("usuarios");
Route::resource('/facturas', FacturaController::class)-> names("facturas");
