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
use App\Models\Estadisticas;
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

            // Получите массив объектов из запроса
            // $mercancias = $request->input('mercancias');

            $data = $request->json()->all();

            // Obtenemos suma de factura
            if (isset($data['f_suma'])) {
                $sumaFactura = $data['f_suma'];
            } else {
                $sumaFactura = 0;
            }

            // Obtenemos direccion de factura
            if (isset($data['role'])) {
                if ($data['role'] === 'manager' || $data['role'] === 'vendedor' ) {
                    $tipoFactura = 0;
                } else {
                    $tipoFactura = 1;
                }
            } else {
                $tipoFactura = 1;
            }

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

            $facturaId = $factura -> factura_id;

            // Убедитесь, что поле 'products' существует и это массив
            if (isset($data['mercancias']) && is_array($data['mercancias'])) {
                $mercancias = $data['mercancias'];

                foreach ($mercancias as $mercancia) {
                    // Проверить, что все необходимые поля присутствуют
                    if (isset($mercancia['m_id_productos']) && isset($mercancia['m_cantidad_pedida'])) {
                        Mercancia::create([
                            'm_id_facturas' => $facturaId, // Убедитесь, что $facturaId определен
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
                        // Обработка ошибки, если данные продукта неполные
                        return response()->json(['error' => 'Данные продукта неполные'], 400);
                    }
                }

                    return response()->json(['message' => 'Продукты успешно сохранены'], 200);
            } else {
                // Обработка ошибки, если продукты не найдены
                    return response()->json(['error' => 'Продукты не найдены'], 400);
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
        // Log::info('Authorization header: ' . $request->header('Authorization'));

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
                    $mercancia  -> m_lugar = $lugar -> lugar_estanteria . "-" . $lugar -> lugar_column . "-" . $lugar -> lugar_planta;
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
        Log::info($id);
        $data = $request->json()->all();

        if (isset($data['f_suma'])) {
            $sumaFactura = $data['f_suma'];
        } else {
            $sumaFactura = 0;
        }

        Factura::findOrFail($id)->update(['f_suma' => $data['f_suma']]);  /** Update factura */
        Mercancia::where('m_id_facturas', $id) -> delete();   /**Borrar datos viejos **/

        // Grabar datos de nuevo

            if (isset($data['mercancias']) && is_array($data['mercancias'])) {
                $mercancias = $data['mercancias'];

                foreach ($mercancias as $mercancia) {

                    if (isset($mercancia['m_id_productos']) && isset($mercancia['m_cantidad_pedida'])) {
                        Mercancia::create([
                            'm_id_facturas' => $id, // Убедитесь, что $facturaId определен
                            'm_id_productos' => $mercancia['m_id_productos'],
                            'm_cantidad_pedida' => $mercancia['m_cantidad_pedida'],
                            'm_suma_pedida' => $mercancia['m_suma_pedida'],
                        ]);
                    } else {
                        // Обработка ошибки, если данные продукта неполные
                        return response()->json(['error' => 'Данные продукта неполные'], 400);
                    }
                }

                    return response()->json(['message' => 'Продукты успешно сохранены'], 200);
            } else {
                // Обработка ошибки, если продукты не найдены
                    return response()->json(['error' => 'Продукты не найдены'], 400);
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

            Log::info($id);
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
                                Log::info('zapuskaem tip factura 0 para producto:');
                                Log::info($mercancia['m_id_productos']);
                                $resto = $mercancia['m_cantidad_recogida']; // Cuantos unidades necesito colocar
                                $full = $producto['p_cantidad_palet'];  // Cuantos unidades en palet
                                Log::info('ostatok tovara:');
                                Log::info($resto);

                                do {
                                    Log::info('cikl do');
                                    $lugar = Lugar::where('lugar_producto',$mercancia['m_id_productos']) ->
                                                    where('lugar_cantidad', '<', $full) -> first ();  // buscamos lugar con producto

                                    if (!$lugar) { // si no hay lugares con producto
                                        Log::info('buscamos nuevo lugar');
                                        $lugar = $this -> buscarLugarNuevo();   // buscamos lugar nuevo
                                        $lugar -> lugar_producto = $mercancia['m_id_productos'];

                                        if ($full > $resto) {
                                            Log::info('$full > $resto');
                                            $lugar -> lugar_cantidad = $resto;
                                            $lugar -> lugar_llenado = $resto/$producto->p_cantidad_palet;
                                            $resto = 0;
                                        } else {
                                            Log::info('$full < $resto');
                                            $lugar -> lugar_cantidad = $full;
                                            $lugar -> lugar_llenado = 100;
                                            $resto -= $full;
                                        }

                                        $lugar -> save();
                                    } else {   // si hay celda desponible
                                        Log::info('celda desponible');
                                        $restoEnCelda = $full - $lugar ->lugar_cantidad; // Cantar cuanto colocamos en esta celda

                                        if ($restoEnCelda > $mercancia['m_cantidad_recogida']) {
                                            Log::info('$restoEnCelda > $mercancia');
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
                                    Log::info('ostatok:');
                                    Log::info($resto);
                                } while ($resto > 0);

                            $mercancia['m_lugares'] = Lugar::where ('lugar_producto',$mercancia['m_id_productos']) -> get ();
                            Log::info('LUGARES');
                            Log::info($mercancia['m_lugares']);


                            } else {  // Si factura salida anadimos campo producto reservado y desminuir campo producto en almacen
                                Log::info('do it contrario');
                                $resto = $mercancia['m_cantidad_recogida']; // Cuantos unidades necesito colocar
                                $full = $producto['p_cantidad_palet'];  // Cuantos unidades en palet

                                do {
                                    Log::info('cikl do');
                                    $lugar = Lugar::where('lugar_producto',$mercancia['m_id_productos']) -> first ();  // buscamos lugar con producto

                                    if (!$lugar) { // si no hay lugares con producto
                                        Log::info('Error');
                                        $resto = 0;


                                    } else {   // si hay celda con mercancia
                                        Log::info('hay mercancia');

                                        if ($lugar -> lugar_cantidad > $resto) {   // Si en la selda cantidad mas que necesito
                                            Log::info('$EnCelda > $mercancia');
                                            $lugar ->lugar_cantidad -= $resto;  // disminuir producto a celda
                                            $lugar -> lugar_llenado = ($lugar ->lugar_cantidad/$producto->p_cantidad_palet)*100;  // Cambiar lli¡enado de la celda

                                            $resto = 0; //  Poner a cero el resto
                                        } else {
                                            Log::info('$EnCelda < $mercancia');
                                            $resto -= $lugar ->lugar_cantidad;  // Diminuir cantidad el celda
                                            $lugar -> lugar_cantidad = 0;  // Poner a cero el resto en la celda
                                            $lugar -> lugar_llenado = 0; // Poner a cero llenado en la celda
                                            $lugar -> lugar_producto = 0; //  borramos info sobre producto
                                        }
                                        $lugar -> save();
                                    }
                                    Log::info($resto);
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

                Log::info('Antes de commit');
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
                            Log::info($planta);
                if ($lugar) {
                    break;
                }
            }
            Log::info('Lugar:');
            Log::info($lugar);

            if ($lugar) {

                return $lugar;
            } else {
                return null;
            }
        }
}
