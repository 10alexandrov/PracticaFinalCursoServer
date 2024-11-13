<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

// Главная страница с перенаправлением
Route::get('/', function () {
    $error = session()->get('error');
    if (Auth::check()) {
        return redirect()->route('home')->with('error', $error);
    }
    return redirect()->route('login'); // Явный редирект на именованный маршрут 'login'
})->name('main'); // Указываем имя

Auth::routes(); // Маршруты для аутентификации

// Home маршрут с использованием контроллера
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

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

