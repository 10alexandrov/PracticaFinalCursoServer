<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Factura;
use App\Models\Mercancia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiFacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facturas = Factura::orderBy('factura_id', 'desc') -> get();
        // Log::info('Authorization header: ' . $request->header('Authorization'));


        $facturas -> map(function($factura) {
            $factura -> usuario_cliente = $factura->usuarioCliente;
            return $factura;
        });


        return $facturas;
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
        //
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
    public function destroy($factura_id)
    {
        try {

            DB::beginTransaction();  // Empesar transaction
            $facturaParaBorrar = Factura::findOrFail($factura_id);
            $mercancias = Mercancia::where('m_id_facturas', $factura_id) -> get();
            foreach ($mercancias as &$mercancia) {   // Volveremos cantidades de todos productos al estado inicial
                $producto = Producto::find($mercancia -> m_id_productos);
                if ($producto) {
                    if ($facturaParaBorrar -> f_tipo == 0) { // Si factura compra
                        $producto -> p_cantidad_entrega -= $mercancia -> m_cantidad_pedida;
                    } else {
                        $producto ->p_cantidad_reservado -= $mercancia -> m_cantidad_pedida;
                        $producto ->p_cantidad_almacen += $mercancia -> m_cantidad_pedida;
                    }
                    $producto -> save();
                }
                $mercancia-> delete();
            }

            $facturaParaBorrar->delete();
            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception -> getMessage();
        }
    }
}
