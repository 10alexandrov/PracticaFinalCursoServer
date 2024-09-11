<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Response;

class ApiUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $usuarios = Usuario::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = new Usuario;
        $usuario->u_nombre = $request->u_nombre;
        $usuario->u_password = $request->u_password;
        $usuario->u_login = $request->u_login;
        $usuario->u_role = $request->u_role;
        $usuario->u_active = $request->u_active;

        try {
            $usuario->save();
        } catch (\Exception $e) {
             return response()->json([ 'error' => true, 'message' => $e->getMessage() ], 500);
        }

        return Response::json(array(
            'error' => false,
            'userId' => $request->u_nombre),
            200
        );
     /*   $data = $request->except('_token');
        Usuario::create($data);

        return "Datos cargados correctamente";

         $usuarios=Usuario::get();
         return $usuarios = Usuario::all();*/
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($usuario_id)
    {
        Usuario::findOrFail($usuario_id)->delete();
    }
}
