<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

    </head>
    <body class="AW-body">
        <div class="main-wrapper">
            <div class ="main-aside">
                @include("include.aside-menu")

            </div>
        </div>
        <div class="main-content">
            <h1> Usuarios </h1>
            <div class="table_container">
                <table>
                    <tr>
                        <th> Usuario </th>
                        <th> Login </th>
                        <th> Role </th>
                        <th> Editar </th>
                        <th> Borrar </th>
                    </tr>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td> {{$usuario->u_nombre}} </td>
                            <td> {{$usuario->u_login}} </td>
                            <td> {{$usuario->u_role}} </td>
                            <td> <a href='{{ route('admin.usuarios.edit', $usuario->id_usuario)}}'>Editar </a></td>
                            <td>
                                <form action="{{ route('admin.usuarios.destroy', $usuario->id_usuario)}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button>Borrar </button>
                                </form>
                            </td>
                        </tr>

                    @endforeach
                </table>
            </div>
            <a  href="{{ route('admin.usuarios.create')}}">
                <button class='m-100'>Crear nuevo usuario </button>
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
</style>
