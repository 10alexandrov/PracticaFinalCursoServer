<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Producto;
use App\Models\Lugar;

class ApiLugarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lugares = Lugar::all();

        $lugares -> map(function($lugar) {
            $lugar -> lugar_productoInfo = $lugar->producto ?? 'unknown';
            return $lugar;
        });

        return $lugares;
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
        $lugar = Lugar::findOrFail($id);
        $lugar -> lugar_productoInfo = $lugar->producto ?? 'disponible';

        return $lugar;
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


        // function para cambiar celdas

        public function cambiar (Request $request) {

            try {

                DB::beginTransaction();  // Empesar transaction

                $data = $request->json()->all();

                $firstId = $data['firstCelda'];
                $secondId = $data['secondCelda'];

                $firstLugar = Lugar::findOrFail($firstId);
                $secondLugar = Lugar::findOrFail($secondId);

                $firstLugarData = $firstLugar->only(['lugar_producto', 'lugar_cantidad', 'lugar_llenado']);
                $secondLugarData = $secondLugar->only(['lugar_producto', 'lugar_cantidad', 'lugar_llenado']);

                $firstLugar -> update($secondLugarData);
                $secondLugar -> update($firstLugarData);

                DB::commit();

                return $this -> index();

            } catch (\Exception $exception) {
                DB::rollBack();
                Log::info($exception);
                return $exception -> getMessage();
            }

        }
}
