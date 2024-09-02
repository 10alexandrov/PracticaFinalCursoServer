<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token for Laravel -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Detalles de Factura</title>

    </head>
    <body class="AW-body">
        <div class="main-wrapper">
            <div class ="main-aside">
                @include("include.aside-menu")

            </div>
        </div>
        <div class="main-content">
            <h1> Detalles de Factura {{ $id }}</h1>

            <div class="table_container">
                <table>
                    <tr>
                        <th> Producto </th>
                        <th> Cantidad </th>
                        <th> Suma </th>
                        <th> Fecha </th>
                        <th> Editar </th>
                        <th> Borrar </th>
                    </tr>
                    @foreach ($mercancias as $mercancia)
                        <tr>
                            <td> {{$mercancia->m_nombre}} </td>
                            <td> {{$mercancia->m_cantidad_pedida}} </td>
                            <td> {{$mercancia->m_suma_pedida}} </td>
                            <td> {{$mercancia->m_fecha_pedida}} </a></td>
                            <td> <a class="anadir" id="{{$mercancia->id}}" href='#'>Anadir </a></td>
                            <td>
                                <form action="#" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button>Borrar </button>
                                </form>
                            </td>
                        </tr>

                    @endforeach
                </table>
            </div>

           <a  href="{{ route('pedido.index')}}">
            <button class='m-100' id="borrarFactura">Volver </button>
          </a>
          <a  href="{{ route('pedido.edit', $id)}}">
            <button class='m-100' id="editarFactura">Editar </button>
          </a>
        </div>
    </body>
</html>

<style>

    .AW-body {
        display:flex;
    }

    .main-content {
        text-align: center;
        width:100%;
    }

    .table_container {
        display: flex;
        justify-content: center;
        align-items: baseline;
    }

    th, td {
        width: 150px;
        text-align: left;
    }

    td {
        font-weight: 400;
    }

    td a{
        font-weight: 800;
        text-decoration: none;
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

    .m-100 {
        margin-top: 100px;
    }

    .d-flex {
        display: flex;
    }

    .linea {
        width: 50%;
        height: 2px;
        background-color: #666;
        justify-content: center;
        margin: 20px 25%;
    }
</style>
