<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Log;

class ApiProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productos = Producto::all();
        Log::info('Authorization header: ' . $request->header('Authorization'));
        Log::info('Index: ' . $productos);


        $productos -> map(function($producto) {
            $producto -> p_nombre_categoria = $producto->categoria->c_nombre ?? 'unknown';
            return $producto;
        });

        return $productos;
    }

        /**
     * Display a listing of the resource with field ACTIVO.
     *
     * @return \Illuminate\Http\Response
     */
    public function activos(Request $request)
    {
        Log::info('Prueba: ');
        Log::info('Authorization header: ' . $request->header('Authorization'));
        $productos = Producto::where('p_activo', true) -> get();

        $productos -> map(function($producto) {
            $producto -> p_nombre_categoria = $producto->categoria->c_nombre ?? 'unknown';
            return $producto;
        });

        return $productos;
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

        $data = $request->except('_token');

        Producto::create($data);
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
        $data = $request->except('_token');

        /*
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $data['p_foto'] = $imagePath; // Asignar la ruta de la imagen al array de datos
        } else {
            $data['p_foto'] = null; // Asignar null si no hay imagen
        }*/

        Producto::findOrFail($id) ->update($data);
        return response()->json(['message' => 'Update con success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($producto_id)
    {
        Producto::findOrFail($producto_id)->delete();
    }
}
