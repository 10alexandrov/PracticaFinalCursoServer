@extends('plantilla.plantilla')
@section('contenido')

        <div class="info-container AW-center">
            <div class="d-flex justify-content-between">
                <h1> Usuarios </h1>
                <a  href="{{ route('usuarios.create')}}">
                    <button class='btn btn-primary mt-2 me-2'>Crear nuevo usuario </button>
                </a>
            </div>
            <div class=" p-2">
                <table class="table table-primary table-bordered">
                    <thead>
                        <tr>
                            <th> Usuario </th>
                            <th> Login </th>
                            <th> Role </th>
                            <th> Active </th>
                            <th> Editar </th>
                            <th> Borrar </th>
                        </tr>
                    </thead>
                    <tbody class='table-group-divider'>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td> {{$usuario->u_nombre}} </td>
                            <td> {{$usuario->u_login}} </td>
                            <td> {{$usuario->u_role}} </td>
                            <td>
                                @if ($usuario->u_active == 1)
                                    <p class="text-success fw-semibold">Activo </p>
                                @elseif ($usuario->u_active == 0)
                                    <p class="text-danger fw-semibold">Inactivo</p>
                                @endif
                            </td>
                            <td> <a href='{{ route('usuarios.edit', $usuario->usuario_id)}}'>
                                    <button class="btn btn-warning">Editar</button>
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('usuarios.destroy', $usuario->usuario_id)}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger">Borrar </button>
                                </form>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

@endsection
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
        height:30px;
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
</style>
