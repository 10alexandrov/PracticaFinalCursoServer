<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FacturaController;

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
    return view('welcome');
}) -> name("home");
Route::get('/recepcion', function () {
    return view('recepcion');
}) -> name("reception"); ;
Route::get('/almacen', function () {
    return view('almacen');
}) -> name("almacen");;
Route::get('/recogida', function () {
    return view('recogida');
}) -> name("recogida");;

Route::resource('/admin/user',UsuarioController::class) -> names("admin.usuarios");
Route::resource('/admin/product',ProductoController::class) -> names("admin.productos");

Route::post('/admin/product/find', [ProductoController::class, 'find']) -> name("admin.productos.find");

Route::resource('/pedido',FacturaController::class);
Route::post('/pedido/store', [FacturaController::class, 'store']);
Route::post('/pedido/find', [FacturaController::class, 'find']) -> name("pedido.find");

