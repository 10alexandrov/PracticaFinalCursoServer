<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Log;

class ApiPruebaController extends Controller
{

    public function index(Request $request)
    {

    Log::info('Prueba: ');
    $productos = Producto::where('p_activo', true) -> first();

    if ($productos) {
        // Возвращаем успешный ответ с данными, чтобы $response->successful() вернул true
        return response()->json([
            'success' => true,
            'data' => $productos
        ], 200);  // 200 OK
    } else {
        // Возвращаем ответ с ошибкой, например, 404 Not Found, если продукт не найден
        return response()->json([
            'success' => false,
            'message' => 'Продукт не найден'
        ], 404);  // 404 Not Found
    }

    }
}
