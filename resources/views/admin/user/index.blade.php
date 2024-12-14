@extends('plantilla.plantilla')
@section('contenido')

        <div class="info-container AW-center">
            <div class="d-flex justify-content-between">
                <h1> Usuarios </h1>
                <a  href="{{ route('users.create')}}">
                    <button class='btn btn-primary mt-2 me-2'>Crear nuevo usuario </button>
                </a>
            </div>
            <div class=" p-2">
                <table class="table table-primary table-bordered">
                    <thead>
                        <tr>
                            <th> Usuario </th>
                            <th> Login </th>
                            <th> Rol </th>
                            <th> Estado </th>
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
                            <td> <a href='{{ route('users.edit', $usuario->usuario_id)}}'>
                                    <button class="btn btn-warning" id="btn-text">Editar</button>
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('users.destroy', $usuario->usuario_id)}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger" id="btn-text">Desactivar </button>
                                </form>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

@endsection
