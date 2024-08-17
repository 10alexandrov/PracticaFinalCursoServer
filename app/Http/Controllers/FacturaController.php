<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Usuario;
use App\Models\Producto;


class FacturaController extends Controller
{

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = 1;
        $facturas=Factura::where('f_id_cliente', '=',$user)->get();
        return view ('pedido.facturas', compact('facturas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos = Producto::get();
        return view ('pedido.create', compact('productos'));
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
    public function destroy($f_id)
    {
        Factura::findOrFail($f_id)->delete();
        $facturas=Factura::get();
        return view ('pedido.facturas', compact('facturas'));
    }


    public function find (Request $request) {

        $buscar = $request->buscar;

        if (!$buscar) {
            $facturas=Factura::get();
        } else {
        $facturas = Factura::where('f_id', $buscar)->get();
        }

        /* - para administrador

        $buscar = $request->buscar;
        $facturas = collect();

        if (!$buscar) {
            $facturas=Factura::get();
        }

        elseif (is_numeric($buscar)) {
            $facturas = Factura::where('f_id', $buscar)->get();
        } else {
            $clientes = Usuario::where('u_nombre', 'LIKE', '%' . $buscar . '%')->get();

            foreach ($clientes as $cliente) {
                $clienteFacturas = Factura::where('f_id_cliente', $cliente->id_usuario)->get();
                $facturas = $facturas->merge($clienteFacturas);
            }
        }

        */
        return view ('pedido.facturas', compact('facturas'));


    }

}
