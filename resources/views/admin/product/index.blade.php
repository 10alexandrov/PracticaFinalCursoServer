<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Product</title>

    </head>
    <body class="AW-body">
        <div class="main-wrapper">
            <div class ="main-aside">
                @include("include.aside-menu")

            </div>
        </div>
        <div class="main-content">
            <h1> Productos </h1>
            <div class='find_container'>
                <form action="{{ route('admin.productos.find')}}" method="POST">
                    @csrf
                    <div class="d-flex" style="margin-left: 100px;">
                        <div class="form-group m-20">
                            <label for="find_categoria">Categoria</label>
                            <select name="find_categoria">
                                <option value="">Elije categoria</option>
                                <option  value="1">Bebidas</option>
                                <option  value="2">Cereales</option>
                                <option  value="3">Enlatada</option>
                                <option  value="4">Pasteleria</option>
                                <option  value="5">Alcohol</option>
                                <option  value="6">Snack</option>
                            </select>
                        </div>
                        <div class="form-group m-20">
                            <label for="p_nombre">Buscar por nombre</label>
                            <input type="text" class="form-control" id="partial" name="partial">
                            <input type="hidden" name="rute" value="admin">
                        </div>
                        <button>Filtrar </button>
                    </div>
                </form>
            </div>
            <div class="table_container">
                <table>
                    <tr>
                        <th> Producto </th>
                        <th> Categoria </th>
                        <th> Cantidad </th>
                        <th> Mostrar </th>
                        <th> Editar </th>
                        <th> Borrar </th>
                    </tr>
                    @foreach ($productos as $producto)
                        <tr>
                            <td> {{$producto->p_nombre}} </td>
                            <td> {{$producto->p_categoria}} </td>
                            <td> {{$producto->p_cantidad_almacen}} </td>
                            <td> <a href='{{ route('admin.productos.show', $producto->id_product)}}'>Mostrar </a></td>
                            <td> <a href='{{ route('admin.productos.edit', $producto->id_product)}}'>Editar </a></td>
                            <td>
                                <form action="{{ route('admin.productos.destroy', $producto->id_product)}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button>Borrar </button>
                                </form>
                            </td>
                        </tr>

                    @endforeach
                </table>
            </div>
            <a  href="{{ route('admin.productos.create')}}">
                <button class='m-100'>Crear nuevo producto </button>
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
