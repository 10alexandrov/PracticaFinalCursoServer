<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mercancia;
use Illuminate\Support\Facades\Log;
use App\Models\Factura;
use App\Http\Controllers\Api\ApiMercanciaController;


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

            if (isset($data['f_suma'])) {
                $sumaFactura = $data['f_suma'];
            } else {
                $sumaFactura = 0;
            }

            // Creamos una factura nueva
            $factura = Factura::create([
                'f_id_cliente' =>1,
                'f_tipo' => 0,
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
