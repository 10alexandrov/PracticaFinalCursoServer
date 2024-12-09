<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios=Usuario::get();
        return view ('admin.user.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
        $data = $request->except('_token');

        // dd($data);

        request()->validate(
            [
                'u_nombre' => 'required',
                'u_login' => 'required',
                'u_password' => 'required|min:8|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
                'u_password2' => 'required|same:u_password',
                'u_role' => 'required',
                'u_active' => 'required'
            ],
            [
                'u_nombre.required' => 'El nombre es obligatorio',
                'u_login.required' => 'El login es obligotorio',
                'u_password.min' => 'Al menos 8 caracteres',
                'u_password.regex' => 'Contraseña debe tener letras, números y símbolos',
                'u_password.required' => 'La contraseña es obligatoria',
                'u_password2.required' => 'La confirmación de contraseña es obligatoria',
                'u_password2.same' => 'Las contraseñas deben coincidir',
                'u_role.required' => 'El rol es obligatorio',
                'u_active.required' => 'Este campo es obligatorio'
            ]
        );

        if (isset ($request->u_password)) {
            $data['u_password'] = Hash::make($request->u_password);
        }

        Usuario::create($data);

        $usuarios=Usuario::get();
        return view ('admin.user.index', compact('usuarios'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario=Usuario::findOrFail($id);
        return view ('admin.user.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');

        request()->validate(
            [
                'u_nombre' => 'required',
                'u_login' => 'required',
                'u_password' => 'required|min:8|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
                'u_password2' => 'required|same:u_password',
                'u_role' => 'required',
                'u_active' => 'required'
            ],
            [
                'u_nombre.required' => 'El nombre es obligatorio',
                'u_login.required' => 'El login es obligotorio',
                'u_password.min' => 'Al menos 8 caracteres',
                'u_password.regex' => 'Contraseña debe tener letras, números y símbolos',
                'u_password.required' => 'La contraseña es obligatoria',
                'u_password2.required' => 'La confirmación de contraseña es obligatoria',
                'u_password2.same' => 'Las contraseñas deben coincidir',
                'u_role.required' => 'El rol es obligatorio',
                'u_active.required' => 'Este campo es obligatorio'
            ]
        );

        if (isset ($request->u_password)) {
            $data['u_password'] = Hash::make($request->u_password);
        }

        Usuario::findOrFail($id) ->update($data);

        $usuarios=Usuario::get();
        return view ('admin.user.index', compact('usuarios'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($usuario_id)
    {
        $usuarioParaDesactivar = Usuario::findOrFail($usuario_id);
        $usuarioParaDesactivar -> u_active = 0;
        $usuarioParaDesactivar -> update ();
        $usuarios=Usuario::get();
        return view ('admin.user.index', compact('usuarios'));
    }
}
