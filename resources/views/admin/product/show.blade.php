<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Show producto</title>

    </head>


    <body class="AW-body">
        <div class="main-wrapper">
            <div class ="main-aside">
                @include("include.aside-menu")

            </div>
        </div>
        <div class="main-content">
            <h1> {{ $producto->p_nombre}}</h1>
                <div class="d-flex">
                    <div>

                        <h2> Medidas </h2>
                        <div class="table_container">
                            <table>
                                <tr>
                                    <th> Altura </th>
                                    <th> Longitud </th>
                                    <th> Anchura </th>
                                    <th> Peso </th>
                                </tr>
                                <tr>
                                    <td> {{ $producto->p_altura}} </td>
                                    <td> {{ $producto->p_longitud}} </td>
                                    <td> {{ $producto->p_ancho}} </td>
                                    <td> {{ $producto->p_peso}} </td>
                                </tr>
                            </table>
                        </div>

                        <h2> Cantidad </h2>
                        <div class="table_container">
                            <table>
                                <tr>
                                    <th> en almacen </th>
                                    <th> en entrega </th>
                                    <th> reservado </th>
                                    <th> enviado </th>
                                </tr>
                                <tr>
                                    <td> {{ $producto->p_cantidad_almacen}} </td>
                                    <td> {{ $producto->p_cantidad_entrega}} </td>
                                    <td> {{ $producto->p_cantidad_reservado}} </td>
                                    <td> {{ $producto->p_cantidad_enviado}} </td>
                                </tr>
                            </table>
                        </div>

                        <h2> Precios </h2>
                        <div>
                            <p> Precios de compra: {{ $producto->p_altura}} </p>
                            <p> Precios de venta: {{ $producto->p_longitud}} </p>
                        </div>
                        <h2> Codigo de barra </h2>
                        <div>
                            <p> Codigo de barra: {{ $producto->p_codigo}} </p>
                        </div>
                    </div>
                    <div>
                        <div class="image">
                            <img src="{{ asset('storage/'.$producto->p_foto)}}">
                        </div>
                        <div class="m-10">
                            <a  href="{{ route('admin.productos.edit', $producto->product_id)}}">
                                <button class='m-100'>Editar </button>
                            </a>
                        </div>
                        <div class="m-10">
                            <a  href="{{ route('admin.productos.destroy', $producto->product_id)}}">
                                <button class='m-100'>Borrar </button>
                            </a>
                        </div>
                        <div class="m-10">
                            <a  href="{{ route('admin.productos.index')}}">
                                <button class='m-100'>Volver </button>
                            </a>
                        </div>
                    </div>
                </div>

        </div>
    </body>

<style>

    .AW-body {
        display:flex;
    }

    .main-content {
        text-align: center;
        width:100%;
    }

    .btn-new {
    border-radius: 10px;
    color: white;
    transition: .2s linear;
    background: #0B63F6;
    }

    .btn-new:hover {
        box-shadow: 0 0 0 2px white, 0 0 0 4px #3C82F8;
    }

    .table_container {
        display: flex;
        justify-content: center;
        align-items: baseline;
    }

    .m-20 {
    margin-top: 20px;
    }

    .m-10 {
        margin-top: 10px;
    }

    td {
        width: 100px;
    }

    .d-flex {
        display: flex;
        justify-content:space-around;
    }

    .image {
        width: 300px;
    }

</style>
</html>
