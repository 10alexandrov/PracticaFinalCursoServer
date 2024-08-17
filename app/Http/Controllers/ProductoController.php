<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

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
        $data = $request->except('_token');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $data['p_foto'] = $imagePath; // Asignar la ruta de la imagen al array de datos
        } else {
            $data['p_foto'] = null; // Asignar null si no hay imagen
        }

        Producto::create($data);

        $productos=Producto::get();
        return view ('admin.product.index', compact('productos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto=Producto::findOrFail($id);
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
        $data = $request->except('_token');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $data['p_foto'] = $imagePath; // Asignar la ruta de la imagen al array de datos
        } else {
            $data['p_foto'] = null; // Asignar null si no hay imagen
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


    public function destroy($id_producto)
    {
        Producto::findOrFail($id_producto)->delete();
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

        return view ('pedido.create', compact('productos'));

        if ($request ->rute ==='pedido') {
            return view ('pedido.create', compact('productos'));

        } else {
            return view ('pedido.create', compact('productos'));
        }
    }
}
