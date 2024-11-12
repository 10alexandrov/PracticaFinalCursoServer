<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Factura;
use App\Models\Estadistica;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiEstadisticasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $date = Carbon::now ();
        $id = $date->format('dmY');
        $estadistica = Estadistica::where('id', $id) -> first();

        if (!$estadistica) {
            $yesterday = Carbon::yesterday ();
            $estadisticaYesterday = null;   // Buscamos estadistica periodo anterior
            while (!$estadisticaYesterday && $yesterday->lt($date)) {
                $idYesterday = $yesterday->format('dmY');
                $estadisticaYesterday = Estadistica::where('id', $idYesterday)->first();
                if (!$estadisticaYesterday) {
                    $yesterday->subDay();
                }
            }

            if ($date->month == $yesterday->month) {
                log::info('prim');
                $e_suma_compras_mes = $estadisticaYesterday -> e_suma_compras_mes;
                $e_suma_ventas_mes = $estadisticaYesterday -> e_suma_ventas_mes;
                $e_beneficios_mes = $estadisticaYesterday -> e_beneficios_mes;
            } else {
                log::info('seg');
                $e_suma_compras_mes = 0;
                $e_suma_ventas_mes = 0;
                $e_beneficios_mes = 0;
            }

            log::info($e_suma_ventas_mes);
            log::info($estadisticaYesterday);

            $estadistica = Estadistica::create([
                'id' => $id,
                'e_fecha' => $date,
                'e_suma_compras_hoy' => 0,
                'e_suma_ventas_hoy' => 0,
                'e_beneficios_hoy' => 0,
                'e_suma_compras_mes' => $e_suma_compras_mes,
                'e_suma_ventas_mes' => $e_suma_ventas_mes,
                'e_beneficios_mes' => $e_beneficios_mes,
                'e_suma_restos' => $estadisticaYesterday -> e_suma_restos,
                'e_volumen_restos' => $estadisticaYesterday -> e_volumen_restos
            ]);

            log::info($estadistica);
            $estadistica -> save ();
        }

        $faltaMercancias = DB::table('productos')
        ->select('p_nombre', 'product_id') // Выбираем только столбцы p_nombre и id_product
        ->where('p_cantidad_almacen', '<', 1) // Условие на количество
        ->get(); // Получаем результат

        /*
        if (!$estadistica) {

            $estadisticaNew = $this -> obtenerEstadistica ($id, $date);

            try {
                $estadisticaNew->save();
                $estadisticaNew -> faltaMercancias = $faltaMercancias;
                return response()->json($estadisticaNew); // Возвращаем созданную запись
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
            }
        } */

        $estadistica -> faltaMercancias = $faltaMercancias;
        // Возвращаем найденную запись
        return response()->json($estadistica);
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
        $estadistica = Estadistica::where('id', $id) -> first();

        if (!$estadistica) {

            $dateString = str_pad($id, 8, '0', STR_PAD_LEFT); // Comprobar hay 0 en primer

            $day = substr($dateString, 0, 2);
            $month = substr($dateString, 2, 2);
            $year = substr($dateString, 4, 4);
            $date = Carbon::createFromDate($year, $month, $day);
            $limitDay = Carbon::create(2024, 7, 31);


                $yesterday = Carbon::createFromDate($year, $month, $day-1);
                log::info ($yesterday);
                $estadisticaYesterday = null;   // Buscamos estadistica periodo anterior
                while (!$estadisticaYesterday && $yesterday -> greaterThan($limitDay)) {
                    $idYesterday = $yesterday->format('dmY');
                    $estadisticaYesterday = Estadistica::where('id', $idYesterday)->first();
                    if (!$estadisticaYesterday) {
                        $yesterday->subDay();
                    }
                }

                if ($date->month == $yesterday->month) {
                    $e_suma_compras_mes = $estadisticaYesterday -> e_suma_compras_mes;
                    $e_suma_ventas_mes = $estadisticaYesterday -> e_suma_ventas_mes;
                    $e_beneficios_mes = $estadisticaYesterday -> e_beneficios_mes;
                } else {
                    $e_suma_compras_mes = 0;
                    $e_suma_ventas_mes = 0;
                    $e_beneficios_mes = 0;
                }

                $estadistica = Estadistica::create([
                    'id' => $id,
                    'e_fecha' => $date,
                    'e_suma_compras_hoy' => 0,
                    'e_suma_ventas_hoy' => 0,
                    'e_beneficios_hoy' => 0,
                    'e_suma_compras_mes' => $e_suma_compras_mes,
                    'e_suma_ventas_mes' => $e_suma_ventas_mes,
                    'e_beneficios_mes' => $e_beneficios_mes,
                    'e_suma_restos' => $estadisticaYesterday -> e_suma_restos,
                    'e_volumen_restos' => $estadisticaYesterday -> e_volumen_restos
                ]);

                $estadistica -> save ();
        }

        return response()->json($estadistica);
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
    public function destroy($id)
    {
        //
    }

    public function obtenerEstadistica ($id, $date) {

        $sumaRestos = Producto::sum(DB::raw('p_precio_compra * p_cantidad_almacen'));
        $volumenRestos = Producto::sum(DB::raw('p_ancho * p_longitud*p_altura*p_cantidad_almacen'));

        $sumaComprasHoy = DB::table('facturas')
        ->whereDate('facturas.created_at', $date->toDateString()) // Проверяем сегодняшнюю дату
        ->where('facturas.f_aceptado', 1) // Только принятые записи
        ->where('facturas.f_tipo', 0) // Условие на поле f_tipo
        ->sum(DB::raw('facturas.f_suma'));

        $sumaVentasHoy = DB::table('facturas')
        ->whereDate('facturas.created_at', $date->toDateString()) // Проверяем сегодняшнюю дату
        ->where('facturas.f_aceptado', 1) // Только принятые записи
        ->where('facturas.f_tipo', 1) // Условие на поле f_tipo
        ->sum(DB::raw('facturas.f_suma'));

        $sumaComprasMes = DB::table('facturas')
        ->whereyear('facturas.created_at', $date->year) // Проверяем сегодняшнюю дату
        ->whereMonth('facturas.created_at', $date->month)
        ->where('facturas.f_aceptado', 1) // Только принятые записи
        ->where('facturas.f_tipo', 0) // Условие на поле f_tipo
        ->sum(DB::raw('facturas.f_suma'));

        $sumaVentasMes = DB::table('facturas')
        ->whereyear('facturas.created_at', $date->year) // Проверяем сегодняшнюю дату
        ->whereMonth('facturas.created_at', $date->month)
        ->where('facturas.f_aceptado', 1) // Только принятые записи
        ->where('facturas.f_tipo', 1) // Условие на поле f_tipo
        ->sum(DB::raw('facturas.f_suma'));

        $sumaBeneficiosHoy = DB::table('mercancias')
        ->join('productos', 'productos.product_id', '=', 'mercancias.m_id_productos') // Соединение таблиц
        ->whereDate('mercancias.m_fecha_recogida', $date->toDateString()) // Проверяем сегодняшнюю дату
        ->sum(DB::raw('(productos.p_precio_venta - productos.p_precio_compra)*mercancias.m_cantidad_recogida'));


        $sumaBeneficiosMes = DB::table('mercancias')
        ->join('productos', 'productos.product_id', '=', 'mercancias.m_id_productos') // Соединение таблиц
        ->whereyear('mercancias.m_fecha_recogida', $date->year) // Проверяем сегодняшнюю дату
        ->whereMonth('mercancias.m_fecha_recogida', $date->month)
        ->sum(DB::raw('(productos.p_precio_venta - productos.p_precio_compra)*mercancias.m_cantidad_recogida'));


        $estadisticaNew = new Estadistica ();
        $estadisticaNew -> id = $id;
        $estadisticaNew-> e_fecha = $date;
        $estadisticaNew -> e_suma_restos = $sumaRestos;
        $estadisticaNew -> e_volumen_restos = $volumenRestos/1000000000;
        $estadisticaNew -> e_suma_compras_hoy = $sumaComprasHoy;
        $estadisticaNew -> e_suma_ventas_hoy = $sumaVentasHoy;
        $estadisticaNew -> e_suma_compras_mes = $sumaComprasMes;
        $estadisticaNew -> e_suma_ventas_mes = $sumaVentasMes;
        $estadisticaNew -> e_beneficios_hoy = $sumaBeneficiosHoy;
        $estadisticaNew -> e_beneficios_mes = $sumaBeneficiosMes;

        return $estadisticaNew;
    }
}
