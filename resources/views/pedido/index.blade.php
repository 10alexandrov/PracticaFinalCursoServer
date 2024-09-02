<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Mis facturas</title>

    </head>
    <body class="AW-body">
        <div class="main-wrapper">
            <div class ="main-aside">
                @include("include.aside-menu")

            </div>
        </div>
        <div class="main-content">
            <h1> Mis facturas </h1>
            <div class='find_container'>
                <form action="{{ route('pedido.find')}}" method="POST">
                    @csrf
                    <div class="d-flex" style="margin-left: 100px;">
                        <div class="form-group m-20">
                            <label for="buscar">Buscar por numero</label>
                            <input type="text" class="form-control" id="buscar" name="buscar">
                        </div>
                        <button>Buscar </button>
                    </div>
                </form>
            </div>
            <div class="table_container">
                <table>
                    <tr>
                        <th> Numero </th>
                        <th> Data pedido </th>
                        <th> Suma </th>
                        <th> Mostrar </th>
                        <th> Editar </th>
                        <th> Borrar </th>
                    </tr>
                    @foreach ($facturas as $factura)
                        <tr>
                            <td> {{$factura->factura_id}} </td>
                            <td> {{$factura->created_at}} </td>
                            <td> {{$factura->f_suma}} </td>
                            <td> <a href='{{ route('pedido.show', $factura->factura_id)}}'>Mostrar </a></td>
                            <td> <a href='{{ route('pedido.edit', $factura->factura_id)}}'>Editar </a></td>
                            <td>
                                <form action="{{ route('pedido.destroy', $factura->factura_id)}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button>Borrar </button>
                                </form>
                            </td>
                        </tr>

                    @endforeach
                </table>
            </div>
            <a  href="{{ route('pedido.create')}}">
                <button class='m-100'>Crear nueva factura </button>
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
</style>
