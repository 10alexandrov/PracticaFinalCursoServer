<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $credentials = $request->only('u_login', 'u_password');
    $credentials['password'] = $credentials['u_password'];
    unset($credentials['u_password']);

    // Попытка найти пользователя по логину
    $usuario = Usuario::where('u_login', $credentials['u_login'])->first();

    // Проверяем, существует ли пользователь и активен ли он
    if (!$usuario || $usuario->u_active != 1) {
        return response()->json(['error' => 'Usuario no está activo o no existe'], 403);
    }

    // Аутентификация через JWT
    if (!$token = JWTAuth::attempt($credentials)) {
        return response()->json(['error' => 'Datos son incorrectos'], 401);
    }

    // Получение информации о пользователе
    $role = $usuario->u_role;  // Роль пользователя
    $usuario_id = $usuario->usuario_id;
    $tokenTTL = JWTAuth::factory()->getTTL() * 60;

    // Возврат токена и данных пользователя
    return response()->json([
        'token' => $token,
        'usuario' => $usuario_id,
        'role' => $role,
        'expires_in' => $tokenTTL
    ]);
}


        // Method para logout

        public function logout()
        {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json(['message' => 'Salir con exito']);
        }


        // Method para informacion sobre usuario

        public function me()
        {
            return response()->json(Auth::user());
        }

        // Method para respuesta con token
        protected function respondWithToken($token)
        {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ]);
        }
}

