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
            <h1> Crear nuevo usuario</h1>

            <div class="form">
                <div class="container mt-5">
                    <div class="table_container">

                        <form action="{{ route('admin.usuarios.update', $usuario->id_usuario) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group m-20">
                                <label for="u_nombre">Nombre usuario</label>
                                <input type="text" class="form-control" id="u_nombre" name="u_nombre" value="{{ $usuario->u_nombre }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="u_login">Login</label>
                                <input type="text" class="form-control" id="u_login" name="u_login" value="{{ $usuario->u_login }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="u_password">Password</label>
                                <input type="text" class="form-control" id="u_password" name="u_password" value="{{ $usuario->u_password }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="u_role">Role</label>
                                <select name="u_role" id="u_role" class="form-control" required>
                                    <option value="recogedor" {{ $usuario->u_role == 'recogedor' ? 'selected' : '' }}>Recogedor</option>
                                    <option value="admin" {{ $usuario->u_role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="manager" {{ $usuario->u_role == 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="cliente" {{ $usuario->u_role == 'cliente' ? 'selected' : '' }}>Cliente</option>
                                    <option value="vendedor" {{ $usuario->u_role == 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                                    <option value="receptor" {{ $usuario->u_role == 'receptor' ? 'selected' : '' }}>Receptor</option>
                                </select>
                            </div>

                             <button class='m-20 btn-new'>Editar usuario </button>
                         </form>
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
</style>
</html>
