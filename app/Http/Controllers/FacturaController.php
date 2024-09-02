<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\Mercancia;
use Carbon\Carbon;


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
        return view ('pedido.index', compact('facturas'));
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
            // $data = $request->except('_token');
            // Usuario::create($data);

            // Получите массив объектов из запроса
            $productos = $request->input('products');

            // Creamos una factura nueva
            $factura = Factura::create([
                'f_id_cliente' =>1,
                'f_tipo' => 0,
                'f_aceptado' => 0
            ]);

            $facturaId = $factura -> factura_id;

            // Декодировать полученный JSON
            $data = $request->json()->all();
            $sumaFactura = 0;

            // Убедитесь, что поле 'products' существует и это массив
            if (isset($data['products']) && is_array($data['products'])) {
                $productos = $data['products'];

                foreach ($productos as $producto) {
                    // Проверить, что все необходимые поля присутствуют
                    if (isset($producto['m_id_productos']) && isset($producto['m_cantidad_pedida'])) {
                        Mercancia::create([
                            'm_id_facturas' => $facturaId, // Убедитесь, что $facturaId определен
                            'm_id_productos' => $producto['m_id_productos'],
                            'm_cantidad_pedida' => $producto['m_cantidad_pedida'],
                        ]);
                        $producto_cantidad = $producto['m_cantidad_pedida'];
                        $producto_precio = Producto::where('product_id',$producto['m_id_productos'])->value('p_precio_venta');
                        $sumaFactura += $producto_precio*$producto_cantidad;
                    } else {
                        // Обработка ошибки, если данные продукта неполные
                        return response()->json(['error' => 'Данные продукта неполные'], 400);
                    }
                } // if ($sumaFactura == 0)
                    $factura->f_suma = $sumaFactura;
                    $factura ->save();
                    // Ответ об успешном выполнении

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
        $mercancias = Mercancia::where('m_id_facturas', '=',$id)->get();

        foreach ($mercancias as $mercancia) {
            // Получаем продукт по его идентификатору
            $mercanciaEncontrada = Producto::find($mercancia->m_id_productos);

            // Проверяем, найден ли продукт, и если да, то присваиваем его имя
            if ($mercanciaEncontrada) {
                $mercancia->m_nombre = $mercanciaEncontrada->p_nombre;
            }
        }

        // $productosJson = $productos -> toJson();

        // return $mercancias;
        return view ('pedido.show')->with('id', $id)->with('mercancias', $mercancias);
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
    public function destroy($factura_id)
    {
        Factura::findOrFail($factura_id)->delete();
        $user = 1;
        $facturas=Factura::where('f_id_cliente', '=',$user)->get();
        return view ('pedido.index', compact('facturas'));
    }


    public function find (Request $request) {

        $buscar = $request->buscar;

        if (!$buscar) {
            $facturas=Factura::get();
        } else {
        $facturas = Factura::where('factura_id', $buscar)->get();
        }

        /* - para administrador

        $buscar = $request->buscar;
        $facturas = collect();

        if (!$buscar) {
            $facturas=Factura::get();
        }

        elseif (is_numeric($buscar)) {
            $facturas = Factura::where('factura_id', $buscar)->get();
        } else {
            $clientes = Usuario::where('u_nombre', 'LIKE', '%' . $buscar . '%')->get();

            foreach ($clientes as $cliente) {
                $clienteFacturas = Factura::where('f_id_cliente', $cliente->usuario_id)->get();
                $facturas = $facturas->merge($clienteFacturas);
            }
        }

        */
        return view ('pedido.index', compact('facturas'));


    }

}
