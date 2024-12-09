@extends('plantilla.plantilla')
@section('contenido')


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Product</title>

    </head>
    <div class="info-container AW-center">
        <div class="d-flex justify-content-between pb-2">
            <h1 class="pt-1"> Productos </h1>
            <a  href="{{ route('product.create')}}">
                <button class='btn btn-primary mt-2 me-2'>Crear nuevo producto </button>
            </a>
        </div>
        <div class='find-container pt-2 mb-1'>
            <form action="{{ route('product.find')}}" method="POST">
                @csrf
                <div class="row pb-2">
                    <div class="form-group col-12 col-sm-10 col-md-5 align-self-center mt-1 row mb-1">
                       <label for="find_categoria" class="col-4 col-md-5" >Categoria</label>
                        <select class="col-8 col-md-7" name="find_categoria">
                            <option value="">Elije categoria</option>
                            <option  value="1">Bebidas</option>
                            <option  value="2">Cereales</option>
                            <option  value="3">Enlatada</option>
                            <option  value="4">Pasteleria</option>
                            <option  value="5">Alcohol</option>
                            <option  value="6">Snack</option>
                        </select>
                    </div>

                    <div class="form-group col-12 col-sm-10 col-md-4 row pb-1">
                        <label class ="col-4 pt-1 align-self-center" for="p_nombre">Buscar</label>
                        <input type="text" class="col-8" id="partial" name="partial">
                        <input type="hidden" name="rute" value="admin">
                    </div>
                    <div class="col-12 col-sm-2 col-md-2 row">
                        <button class=" btn btn-dark w-75 m-auto">Filtrar </button>
                    </div>
                </div>
            </form>
        </div>
            <div class="table_container">
                <table class="table table-bordered table-primary">
                    <tr>
                        <th> Producto </th>
                        <th class="tablet-hidden"> Categoria </th>
                        <th class="mobile-hidden"> Actividad </th>
                        <th> Mostrar </th>
                        <th> Editar </th>
                        <th> Borrar </th>
                    </tr>
                    @foreach ($productos as $producto)
                        <tr>
                            <td> {{$producto->p_nombre}} </td>
                            <td class="tablet-hidden"> {{$producto->p_categoria}} </td>
                            <td class="mobile-hidden">
                                @if ($producto->p_activo)
                                    <p class="text-success"> Activo </p>
                                @else
                                    <p class="text-danger">Inactivo </p>
                                @endif
                            </td>
                            <td> <a href='{{ route('product.show', $producto->product_id)}}'>
                                    <button class="btn btn-primary" id="btn-text">Mostrar</button>
                                </a>
                            </td>
                            <td> <a href='{{ route('product.edit', $producto->product_id)}}'>
                                    <button class="btn btn-warning" id="btn-text"> Editar </button>
                                </a></td>
                            <td>
                                <form action="{{ route('product.destroy', $producto->product_id)}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger">Desactivar </button>
                                </form>
                            </td>
                        </tr>

                    @endforeach
                </table>
            </div>
        </div>
    </div>
</html>

@endsection

<style>

    .AW-body {
        display:flex;
    }

    .main-content {
        text-align: center;
        width:100%;
    }

    .find-container {
        background-color: #bbb;
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
