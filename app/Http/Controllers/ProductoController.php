<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Mercancia;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    public function index () {
        $productos=Producto::get();
        return view ('admin.product.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
        request()->validate(
            [
                'p_nombre' => 'required',
                'p_categoria' => 'required',
                'p_ancho' => 'required | integer',
                'p_longitud' => 'required | integer',
                'p_altura'=> 'required | integer',
                'p_peso'=> 'required | integer',
                'p_precio_compra'=> 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'p_precio_venta'=> 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'p_codigo'=> 'required | digits:13',
                'p_cantidad_palet'=> 'required|integer'
            ],
            [
                'p_nombre.required' => 'Este campo es obligatorio',
                'p_categoria.required'=> 'Este campo es obligatorio',
                'p_ancho.required' => 'Este campo es obligatorio',
                'p_ancho.integer' => 'En este campo solo digitos',
                'p_longitud.required'=> 'Este campo es obligatorio',
                'p_longitud.integer' => 'En este campo solo digitos',
                'p_altura.required' => 'Este campo es obligatorio',
                'p_altura.integer' => 'En este campo solo digitos',
                'p_peso.required' => 'Este campo es obligatorio',
                'p_peso.integer' => 'En este campo solo digitos',
                'p_precio_compra.required'=> 'Este campo es obligatorio',
                'p_precio_compra.numeric' => 'En este campo solo digitos',
                'p_precio_compra.regex'  => 'No más de dos decimales',
                'p_precio_venta.required' => 'Este campo es obligatorio',
                'p_precio_venta.numeric' => 'En este campo solo digitos',
                'p_precio_venta.regex' => 'No más de dos decimales',
                'p_codigo.required' => 'Este campo es obligatorio',
                'p_codigo.digits' => 'En este campo solo 13 digitos',
                'p_cantidad_palet.required'=> 'Este campo es obligatorio',
                'p_cantidad_palet.integer' => 'En este campo solo digitos'
            ]
        );
        $data = $request->except('_token');


        if ($request->hasFile('image')) {

            // dd($request->file('image'));

            $imageBase64 = 'data:image/' . $request->file('image')->extension() . ';base64,' .
                        base64_encode(file_get_contents($request->file('image')->getRealPath()));
            $data['p_foto'] = $imageBase64;
            /*
            $imagePath = $request->file('image')->store('images', 'public');
            $data['p_foto'] = $imagePath; // Asignar la ruta de la imagen al array de datos*/
        } else {
            $data['p_foto'] = null; // Asignar null si no hay imagen
        }

        $data['p_peso_palet'] = $data['p_peso']*$data['p_cantidad_palet']/1000;
        $data['p_cantidad_almacen'] = 0;
        $data['p_cantidad_entrega'] = 0;
        $data['p_cantidad_reservado'] = 0;
        $data['p_cantidad_enviado'] = 0;

        try {
            Producto::create($data);
        } catch (\Exception $exception) {

            Log::info($exception);
            return $exception -> getMessage();
        }

        $productos=Producto::get();
        return view ('admin.product.index', compact('productos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($producto_id)
    {
        $producto=Producto::findOrFail($producto_id);
        return view ('admin.product.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto=Producto::findOrFail($id);
        return view ('admin.product.edit', compact('producto'));
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
        request()->validate(
            [
                'p_nombre' => 'required',
                'p_categoria' => 'required',
                'p_ancho' => 'required | integer',
                'p_longitud' => 'required | integer',
                'p_altura'=> 'required | integer',
                'p_peso'=> 'required | integer',
                'p_precio_compra'=> 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'p_precio_venta'=> 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'p_codigo'=> 'required | digits:13',
                'p_cantidad_palet'=> 'required|integer'
            ],
            [
                'p_nombre.required' => 'Este campo es obligatorio',
                'p_categoria.required'=> 'Este campo es obligatorio',
                'p_ancho.required' => 'Este campo es obligatorio',
                'p_ancho.integer' => 'En este campo solo digitos',
                'p_longitud.required'=> 'Este campo es obligatorio',
                'p_longitud.integer' => 'En este campo solo digitos',
                'p_altura.required' => 'Este campo es obligatorio',
                'p_altura.integer' => 'En este campo solo digitos',
                'p_peso.required' => 'Este campo es obligatorio',
                'p_peso.integer' => 'En este campo solo digitos',
                'p_precio_compra.required'=> 'Este campo es obligatorio',
                'p_precio_compra.numeric' => 'En este campo solo digitos',
                'p_precio_compra.regex'  => 'No más de dos decimales',
                'p_precio_venta.required' => 'Este campo es obligatorio',
                'p_precio_venta.numeric' => 'En este campo solo digitos',
                'p_precio_venta.regex' => 'No más de dos decimales',
                'p_codigo.required' => 'Este campo es obligatorio',
                'p_codigo.digits' => 'En este campo solo 13 digitos',
                'p_cantidad_palet.required'=> 'Este campo es obligatorio',
                'p_cantidad_palet.integer' => 'En este campo solo digitos'
            ]
        );

        $data = $request->except('_token');

        if ($request->hasFile('image')) {

            // dd($request->file('image'));

            $imageBase64 = 'data:image/' . $request->file('image')->extension() . ';base64,' .
                        base64_encode(file_get_contents($request->file('image')->getRealPath()));
            $data['p_foto'] = $imageBase64;
            /*
            $imagePath = $request->file('image')->store('images', 'public');
            $data['p_foto'] = $imagePath; // Asignar la ruta de la imagen al array de datos*/
        }

        Producto::findOrFail($id) ->update($data);

        $productos=Producto::get();
        return view ('admin.product.index', compact('productos'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy($producto_id)
    {
        $productoParaDesactivar = Producto::findOrFail($producto_id);
        $productoParaDesactivar -> p_activo = 0;
        $productoParaDesactivar -> update ();
        $productos=Producto::get();
        return view ('admin.product.index', compact('productos'));
    }

    public function find (Request $request) {

        $category = $request->find_categoria;
        $name = $request->partial;

        if ($request->find_categoria && $request->partial) {
            $productos=Producto::where('p_categoria','=',$category)-> where('p_nombre','LIKE','%'.$name.'%')->get();

        } elseif ($request->partial) {
            $productos=Producto::where('p_nombre','LIKE','%'.$name.'%')->get();
        } elseif ($request->find_categoria) {
            $productos=Producto::where('p_categoria','=',$category)->get();
        }
         else {
            $productos=Producto::get();

        }

        return view ('admin.product.index', compact('productos'));

    }

    public function prueboUsoProducto ($producto_id) {

        $pruebaUsoProducto = Mercancia::findOrFail($producto_id);

        if ($pruebaUsoProducto) {
            return true;
        } else {
            return false;
        }

    }
}
