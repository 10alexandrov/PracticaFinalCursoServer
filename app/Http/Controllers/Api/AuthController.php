<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Usuarios;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
        // Method pata login

        public function login(Request $request)
        {
            $credentials = $request->only('u_login', 'u_password');
            $credentials['password'] = $credentials['u_password'];
            unset($credentials['u_password']);

            \Log::info('Attempting login with credentials:', $credentials);

            if (!$token = JWTAuth::attempt($credentials)) {
                \Log::error('Login failed for credentials:', $credentials);
                return response()->json(['error' => 'Datos son incorrectos'], 401);
            }

            $usuario = auth() -> user();    // Obtener usuario autorizado
            $role = $usuario -> u_role;  // Obtener role de usuario
            $tokenTTL = auth('api')->factory()->getTTL()*60;

            return response () -> json ([
                'token' => $token,
                'role' => $role,
                'expires_in' => $tokenTTL]);
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

