<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Mercancia;
use Illuminate\Support\Facades\Log;
use App\Models\Factura;
use App\Models\Producto;
use App\Models\Lugar;
use App\Models\Estadistica;
use App\Http\Controllers\Api\ApiMercanciaController;
use Carbon\Carbon;


class ApiMercanciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mercancias = Mercancia::all();

        return $mercancias;
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
        try {

            DB::beginTransaction();  // Empesar transaction

            $data = $request->json()->all();

            // Obtenemos suma de factura
            if (isset($data['f_suma'])) {
                $sumaFactura = $data['f_suma'];
            } else {
                $sumaFactura = 0;
            }

            // Obtenemos direccion de factura

            $tipoFactura = $this -> obtenerTipoFactura ($data['role']);

            // Obtenemos usuario - author de factura
            if (isset($data['usuario'])) {
                $usuarioFactura = $data['usuario'];
            } else {
                $usuarioFactura = 1;
            }

            // Creamos una factura nueva
            $factura = Factura::create([
                'f_id_cliente' =>$usuarioFactura,
                'f_tipo' => $tipoFactura,
                'f_aceptado' => 0,
                'f_suma' => $sumaFactura,
                'f_suma_tramitacion' => 0
            ]);

            // Obtenemos numero de factura
            $facturaId = $factura -> factura_id;

            if (isset($data['mercancias']) && is_array($data['mercancias'])) {
                $mercancias = $data['mercancias'];
                foreach ($mercancias as $mercancia) {
                    $this -> saveMercancia ($mercancia, $facturaId, $tipoFactura);  // guardamos mercancia a BD
                }

                DB::commit();
                return response()->json(['message' => 'Datos guardadodos correctamente'], 200);
            } else {
                return response()->json(['error' => 'No hay productos'], 400);
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::info($exception);
            return $exception -> getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $mercancias = Mercancia::where('m_id_facturas', $id) -> get();


        $mercancias -> map(function($mercancia) {
            $mercancia -> m_nombre_producto = $mercancia->producto->p_nombre ?? 'unknown';
            $mercancia -> m_precio_venta = $mercancia->producto->p_precio_venta ?? 0;
            $mercancia -> m_precio_compra = $mercancia->producto->p_precio_compra ?? 0;
            return $mercancia;
        });

        return $mercancias;
    }



    public function showWidthPlace($id)
    {
        $mercancias = Mercancia::where('m_id_facturas', $id) -> get();

        if (isset ($mercancias)) {
            foreach ($mercancias as $mercancia) {
                $lugar = Lugar::where('lugar_producto', $mercancia -> m_id_productos) -> first();  // Buscamos producto primero

                if ($lugar) {
                    $mercancia  -> m_lugar = $lugar -> lugar_estanteria . "-" . $lugar -> lugar_planta . "-" . $lugar -> lugar_column;
                } else {
                    $mercancia  -> m_lugar = "No hay en Almacen";
                }
                $mercancia -> m_nombre_producto = $mercancia->producto->p_nombre ?? 'unknown';
                $mercancia -> m_precio_venta = $mercancia->producto->p_precio_venta ?? 0;
                $mercancia -> m_precio_compra = $mercancia->producto->p_precio_compra ?? 0;
            }
        }

        return $mercancias;
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
        try {

            DB::beginTransaction();  // Empesar transaction
            $data = $request->json()->all();

            if (isset($data['f_suma'])) {
                $sumaFactura = $data['f_suma'];
            } else {
                $sumaFactura = 0;
            }

            $facturaControlado = Factura::findOrFail($id);  // renovar datos de la factura
            $facturaControlado ->update(['f_suma' => $data['f_suma']]);  /** Update factura */
            $tipoFactura = $facturaControlado -> f_tipo;    // Obtener tipo factura compra/venta
            $mercanciasViejo = Mercancia::where('m_id_facturas', $id) -> get(); // Guardar datos viejos
            Mercancia::where('m_id_facturas', $id) -> delete();   /**Borrar datos viejos **/

            // Grabar datos de nuevo
            if (isset($data['mercancias']) && is_array($data['mercancias'])) {
                $this -> updateMercancias ($data['mercancias'], $mercanciasViejo,  $id, $tipoFactura);
                DB::commit();
                return response()->json(['message' => 'Datos guardadodos correctamente'], 200);

            } else {

                return response()->json(['error' => 'No hay mercancias'], 400);
            }


        } catch (\Exception $exception) {
            DB::rollBack();
            Log::info($exception);
            return $exception -> getMessage();
        }
    }


        /**
     * Update with acept the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function aceptar(Request $request, $id)
    {
        try {

            DB::beginTransaction();  // Empesar transaction

            $data = $request->json()->all();
            $date = Carbon::now ();

            if (isset($data['f_suma'])) {
                $sumaFactura = $data['f_suma'];
            } else {
                $sumaFactura = 0;
            }

            if (isset($data['aceptarFactura'])) {
                $f_aceptado = $data['aceptarFactura'];
            } else {
                $f_aceptado = 0;
            }

            if (isset($data['usuario'])) {
                $f_id_responsable = $data['usuario'];
            } else {
                $f_id_responsable = 1;
            }

            $facturaControlado = Factura::findOrFail($id);  // renovar datos de la factura
            $tipoFactura = $facturaControlado -> f_tipo;
                $facturaControlado->update(['f_suma_tramitacion' => $sumaFactura,
                                            'f_aceptado'=> $f_aceptado,
                                            'f_fecha_tramitacion' => $date,
                                            'f_id_responsable' => $f_id_responsable]);



            // Grabar datos de nuevo

                if (isset($data['mercancias']) && is_array($data['mercancias'])) {
                    $mercancias = $data['mercancias'];

                    foreach ($mercancias as &$mercancia) {

                        if (isset($mercancia['id'])) {
                            Mercancia::where ('id', $mercancia['id'])-> update([
                                'm_cantidad_recogida' => $mercancia['m_cantidad_recogida'],
                                'm_suma_recogida' => $mercancia['m_suma_recogida'],
                                'm_aceptado' => $mercancia['m_aceptado'],
                            ]);

                            //  Corregir datos de restos en tabla productos

                            $producto = Producto::findOrFail($mercancia['m_id_productos']);

                            if ($tipoFactura == 0) {  // Si factura entrada anadimos campo producto enviado
                                $producto->decrement('p_cantidad_entrega',$mercancia['m_cantidad_recogida']);
                                $producto->increment('p_cantidad_almacen',$mercancia['m_cantidad_recogida']);
                            } else {  // Si factura salida anadimos campo producto reservado y desminuir campo producto en almacen
                                $producto->decrement('p_cantidad_reservado', $mercancia['m_cantidad_recogida']);
                                $producto->increment('p_cantidad_enviado',$mercancia['m_cantidad_recogida']);
                            }

                            // Logica de lugar en almacen     **************************
                            if ($tipoFactura == 0) {  // Si factura entrada
                                $resto = $mercancia['m_cantidad_recogida']; // Cuantos unidades necesito colocar
                                $full = $producto['p_cantidad_palet'];  // Cuantos unidades en palet

                                do {
                                    $lugar = Lugar::where('lugar_producto',$mercancia['m_id_productos']) ->
                                                    where('lugar_cantidad', '<', $full) -> first ();  // buscamos lugar con producto

                                    if (!$lugar) { // si no hay lugares con producto
                                        $lugar = $this -> buscarLugarNuevo();   // buscamos lugar nuevo
                                        $lugar -> lugar_producto = $mercancia['m_id_productos'];

                                        if ($full > $resto) {
                                            $lugar -> lugar_cantidad = $resto;
                                            $lugar -> lugar_llenado = $resto/$producto->p_cantidad_palet;
                                            $resto = 0;
                                        } else {
                                            $lugar -> lugar_cantidad = $full;
                                            $lugar -> lugar_llenado = 100;
                                            $resto -= $full;
                                        }

                                        $lugar -> save();
                                    } else {   // si hay celda desponible
                                        $restoEnCelda = $full - $lugar ->lugar_cantidad; // Cantar cuanto colocamos en esta celda

                                        if ($restoEnCelda > $mercancia['m_cantidad_recogida']) {
                                            $lugar ->lugar_cantidad += $mercancia['m_cantidad_recogida'];  // Colocamos producto a celda
                                            $lugar -> lugar_llenado = ($lugar ->lugar_cantidad/$producto->p_cantidad_palet)*100;  // Cambiar lli¡enado de la celda

                                            $resto = 0; //  Poner a cero el resto
                                        } else {
                                            Log::info('$restoEnCelda < $mercancia');
                                            $lugar ->lugar_cantidad += $restoEnCelda;  // Colocamos producto a celda
                                            $lugar -> lugar_llenado = 100; // La Celda es llena
                                            $resto -= $restoEnCelda;  // Diminuir cantidad de factura
                                        }
                                        $lugar -> save();
                                    }

                                } while ($resto > 0);

                            $mercancia['m_lugares'] = Lugar::where ('lugar_producto',$mercancia['m_id_productos']) -> get ();


                            } else {  // Si factura salida anadimos campo producto reservado y desminuir campo producto en almacen

                                $resto = $mercancia['m_cantidad_recogida']; // Cuantos unidades necesito colocar
                                $full = $producto['p_cantidad_palet'];  // Cuantos unidades en palet

                                do {
                                    $lugar = Lugar::where('lugar_producto',$mercancia['m_id_productos']) -> first ();  // buscamos lugar con producto

                                    if (!$lugar) { // si no hay lugares con producto
                                        $resto = 0;

                                    } else {   // si hay celda con mercancia

                                        if ($lugar -> lugar_cantidad > $resto) {   // Si en la selda cantidad mas que necesito
                                            $lugar ->lugar_cantidad -= $resto;  // disminuir producto a celda
                                            $lugar -> lugar_llenado = ($lugar ->lugar_cantidad/$producto->p_cantidad_palet)*100;  // Cambiar lli¡enado de la celda

                                            $resto = 0; //  Poner a cero el resto
                                        } else {
                                            $resto -= $lugar ->lugar_cantidad;  // Diminuir cantidad el celda
                                            $lugar -> lugar_cantidad = 0;  // Poner a cero el resto en la celda
                                            $lugar -> lugar_llenado = 0; // Poner a cero llenado en la celda
                                            $lugar -> lugar_producto = 0; //  borramos info sobre producto
                                        }
                                        $lugar -> save();
                                    }

                                } while ($resto > 0);

                            }

                        } else {
                            // Обработка ошибки, если данные продукта неполные
                            return response()->json(['error' => 'Данные продукта неполные'], 400);
                        }
                    }


                } else {
                    // Обработка ошибки, если продукты не найдены
                        return response()->json(['error' => 'Продукты не найдены'], 400);
                }

                if ($f_aceptado) {  // si factura esta aceptado - anadimos estadisticas
                    $this -> estadisticas ($id, $facturaControlado, $data['mercancias']);
                }

                DB::commit();

            } catch (\Exception $exception) {
                return $exception -> getMessage();
            }

            return $mercancias;

            Log::info ($mercancias);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // function para buscar lugar nuevo
    function buscarLugarNuevo () {
        $lugar = null;
        $plantas = [1, 2, 3];

            foreach ($plantas as $planta) {
                $lugar = Lugar::where('lugar_cantidad', 0)
                            ->where('lugar_planta', $planta)
                            ->first();
                if ($lugar) {
                    break;
                }
            }

            if ($lugar) {

                return $lugar;
            } else {
                return null;
            }
        }

        // function para obtener tipo factura 0 = compra 1 = venta
        private function obtenerTipoFactura ($data) {
            if ($data) {
                if ($data === 'manager' || $data === 'vendedor' ) {
                    return 0;
                } else {
                    return 1;
                }
            } else {
                return 1;
            }
        }

    // function para guardar mercancia
    private function saveMercancia ($mercancia, $facturaId, $tipoFactura) {

        if (isset($mercancia['m_id_productos']) && isset($mercancia['m_cantidad_pedida'])) {
            Mercancia::create([
                'm_id_facturas' => $facturaId,
                'm_id_productos' => $mercancia['m_id_productos'],
                'm_cantidad_pedida' => $mercancia['m_cantidad_pedida'],
                'm_suma_pedida' => $mercancia['m_suma_pedida'],
            ]);

            // Anadimos datos de tabala de producto

            $producto = Producto::findOrFail($mercancia['m_id_productos']);

            if ($tipoFactura == 0) {  // Si factura entrada anadimos campo producto enviado
                $producto->increment('p_cantidad_entrega',$mercancia['m_cantidad_pedida']);
            } else {  // Si factura salida anadimos campo producto reservado y desminuir campo producto en almacen
                $producto->decrement('p_cantidad_almacen', $mercancia['m_cantidad_pedida']);
                $producto->increment('p_cantidad_reservado',$mercancia['m_cantidad_pedida']);
            }

        } else {
            // Si datos incorrectos
            return response()->json(['error' => 'Datos de factura incorrectos'], 400);
        }
    }


    private function updateMercancias ($mercancias, $mercanciasViejo, $id, $tipoFactura) {
        LOG::info('updateMercancias');
            foreach ($mercancias as $mercancia) {
                LOG::info($mercancia['m_cantidad_pedida']);
                if (isset($mercancia['m_id_productos']) && isset($mercancia['m_cantidad_pedida'])) {
                    LOG::info('updateMercancias');
                    Mercancia::create([
                        'm_id_facturas' => $id, // Убедитесь, что $facturaId определен
                        'm_id_productos' => $mercancia['m_id_productos'],
                        'm_cantidad_pedida' => $mercancia['m_cantidad_pedida'],
                        'm_suma_pedida' => $mercancia['m_suma_pedida'],
                    ]);

                    // Anadimos datos de tabala de producto
                    $producto = Producto::findOrFail($mercancia['m_id_productos']);
                    $restosViejos = isset($mercancia['id']) ? $this -> getCantidadPedidaById($mercanciasViejo, $mercancia['id']) : 0;

                    if ($tipoFactura == 0) {  // Si factura entrada anadimos campo producto enviado
                        $producto->decrement('p_cantidad_entrega',$restosViejos);
                        $producto->increment('p_cantidad_entrega',$mercancia['m_cantidad_pedida']);
                    } else {  // Si factura salida anadimos campo producto reservado y desminuir campo producto en almacen
                        $producto->increment('p_cantidad_almacen', $restosViejos);
                        $producto->decrement('p_cantidad_reservado',$restosViejos);
                        $producto->decrement('p_cantidad_almacen', $mercancia['m_cantidad_pedida']);
                        $producto->increment('p_cantidad_reservado',$mercancia['m_cantidad_pedida']);
                    }

                } else {
                    // Si datos incomplited
                    return response()->json(['error' => 'Datos incomplited'], 400);
                }
            }

    }

    // Buscar cantidad por Id
    private function getCantidadPedidaById($array, $id) {

        $collection = collect($array);

        $item = $collection->firstWhere('id', $id);

        return $item ? $item['m_cantidad_pedida'] : null;
    }

    // corregir estadisticas con cada nueva factura
    private function estadisticas ($idFactura, $factura, $mercancias) {

    try {
        $date = Carbon::now ();
        $yesterday = Carbon::yesterday ();
        $id = $date->format('dmY');
        $estadistica = Estadistica::where('id', $id) -> first();

        $newDay = !$estadistica;  // El dia nueva o no

        if (!$estadistica) { $estadistica = new Estadistica; }   // Si no hay estadistica creamos objeto nuevo

        $estadisticaYesterday = null;   // Buscamos estadistica periodo anterior
        while (!$estadisticaYesterday && $yesterday->lt($date)) {
            $idYesterday = $yesterday->format('dmY');
            $estadisticaYesterday = Estadistica::where('id', $idYesterday)->first();
            if (!$estadisticaYesterday) {
                $yesterday->subDay();
            }
        }

        $estadisticaNew = new Estadistica ();
        $estadisticaNew->e_volumen_restos = 0;
        $estadisticaNew->e_suma_restos = 0;
        $estadisticaNew->e_suma_ventas_hoy = 0;
        $estadisticaNew->e_beneficios_hoy = 0;

        if ($factura -> f_tipo) {   // Si es factura venta
            foreach ($mercancias as $mercancia) {
                $producto = Producto::findOrFail($mercancia['m_id_productos']);
                $e_volumen_restos = ($producto->p_ancho*$producto->p_altura*$producto->p_longitud)/1000000000;
                $e_suma_restos = $mercancia ['m_suma_recogida'];
                $e_beneficios_hoy = ($producto->p_precio_venta-$producto->p_precio_compra)*$mercancia['m_cantidad_recogida'];

                $estadisticaNew -> e_volumen_restos += $e_volumen_restos;
                $estadisticaNew -> e_suma_restos += $e_suma_restos;
                $estadisticaNew -> e_suma_ventas_hoy += $e_suma_restos;
                $estadisticaNew -> e_beneficios_hoy += $e_beneficios_hoy;
            }

            $estadistica -> id = $id;
            $estadistica -> e_fecha = $date;
            log::info($estadisticaNew);
            if ($newDay) {
                $estadistica -> e_volumen_restos = $estadisticaYesterday -> e_volumen_restos - $estadisticaNew -> e_volumen_restos;
                $estadistica -> e_suma_restos = $estadisticaYesterday ->e_suma_restos - $estadisticaNew -> e_suma_restos;
                $estadistica -> e_suma_ventas_hoy = $estadisticaNew -> e_suma_ventas_hoy;
                $estadistica -> e_suma_compras_hoy = 0;
                $estadistica -> e_beneficios_hoy = $estadisticaNew -> e_beneficios_hoy;
            } else {
                $estadistica -> increment ('e_suma_ventas_hoy', $estadisticaNew -> e_suma_ventas_hoy);
                $estadistica -> decrement ('e_volumen_restos', $estadisticaNew -> e_volumen_restos);
                $estadistica -> decrement ('e_suma_restos', $estadisticaNew -> e_suma_restos);
                $estadistica -> increment ('e_beneficios_hoy', $estadisticaNew -> e_beneficios_hoy);
            }

            if ($date->month == $yesterday->month && $newDay) {
                $estadistica -> e_suma_ventas_mes = $estadisticaYesterday->e_suma_ventas_mes + $estadisticaNew -> e_suma_ventas_hoy;
                $estadistica -> e_beneficios_mes = $estadisticaYesterday->e_beneficios_mes + $estadisticaNew -> e_beneficios_hoy;
                $estadistica -> e_suma_compras_mes = $estadisticaYesterday->e_suma_compras_mes;
            } else if ($date->month !== $yesterday->month && $newDay) {
                $estadistica -> e_suma_ventas_mes = $estadisticaNew -> e_suma_ventas_hoy;
                $estadistica -> e_beneficios_mes = $estadisticaNew -> e_beneficios_hoy;
                $estadistica -> e_suma_compras_mes = 0;
            } else  {
                $estadistica -> increment ('e_suma_ventas_mes',  $estadisticaNew -> e_suma_ventas_hoy);
                $estadistica -> increment ('e_beneficios_mes', $estadisticaNew -> e_beneficios_hoy);
            }

            log::info($estadistica);
            $estadistica ->save();

        } else {   // Si es factura compra
            foreach ($mercancias as $mercancia) {

                $producto = Producto::findOrFail($mercancia['m_id_productos']);
                $e_volumen_restos = ($producto->p_ancho*$producto->p_altura*$producto->p_longitud)/1000000000;
                $e_suma_restos = $mercancia['m_suma_recogida'];

                $estadisticaNew -> e_volumen_restos += $e_volumen_restos;
                $estadisticaNew -> e_suma_restos += $e_suma_restos;
                $estadisticaNew -> e_suma_compras_hoy += $e_suma_restos;
            }

            $estadistica -> id = $id;
            $estadistica -> e_fecha = $date;
            if ($newDay) {
                $estadistica -> e_volumen_restos = $estadisticaYesterday -> e_volumen_restos + $estadisticaNew -> e_volumen_restos;
                $estadistica -> e_suma_restos = $estadisticaYesterday ->e_suma_restos +  $estadisticaNew -> e_suma_restos;
                $estadistica -> e_suma_compras_hoy = $estadisticaNew -> e_suma_compras_hoy;
                $estadistica -> e_suma_ventas_hoy = 0;
                $estadistica -> e_beneficios_hoy = 0;
            } else {
                $estadistica -> increment ('e_suma_compras_hoy', $estadisticaNew -> e_suma_compras_hoy);
                $estadistica -> increment ('e_volumen_restos', $estadisticaNew -> e_volumen_restos);
                $estadistica -> increment ('e_suma_restos', $estadisticaNew -> e_suma_restos);
                $estadistica -> e_beneficios_hoy = $estadistica -> e_beneficios_hoy;
            }

            if ($date->month == $yesterday->month && $newDay) {
                $estadistica -> e_suma_compras_mes = $estadisticaYesterday->e_suma_compras_mes + $estadisticaNew -> e_suma_compras_hoy;
                $estadistica -> e_suma_ventas_mes = $estadisticaYesterday->e_suma_ventas_mes;
                $estadistica -> e_beneficios_mes = $estadisticaYesterday-> e_beneficios_mes;
            } else if ($date->month !== $yesterday->month && $newDay) {
                $estadistica -> e_suma_compras_mes = $estadisticaNew -> e_suma_compras_hoy;
                $estadistica -> e_suma_ventas_mes = 0;
                $estadistica -> e_beneficios_mes =0;
            } else  {
                $estadistica -> increment ('e_suma_compras_mes',  $estadisticaNew -> e_suma_compras_hoy);
                $estadistica -> e_suma_ventas_mes = $estadistica -> e_suma_ventas_mes;
                $estadistica -> e_beneficios_mes = $estadistica -> e_beneficios_mes;
            }
            log::info ($estadistica);
            $estadistica ->save();

        }

    } catch (\Exception $exception) {

        Log::info($exception);
        return $exception -> getMessage();
    }
    }
}
