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

                        <form action="{{ route('admin.usuarios.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group m-20">
                                <label for="u_nombre">Nombre usuario</label>
                                <input type="text" class="form-control" id="u_nombre" name="u_nombre" value="{{ old('u_nombre') }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="u_login">Login</label>
                                <input type="text" class="form-control" id="u_login" name="u_login" value="{{ old('u_login') }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="u_password">Password</label>
                                <input type="text" class="form-control" id="u_password" name="u_password" value="{{ old('u_password') }}" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="u_role">Role</label>
                                <select name="u_role" required>
                                    <option  value="recogedor">Recogedor</option>
                                    <option  value="admin">Admin</option>
                                    <option  value="manager">Manager</option>
                                    <option  value="cliente">Cliente</option>
                                    <option  value="vendedor">Vendedor</option>
                                    <option  value="receptor">Receptor</option>
                                </select>
                            </div>

                             <button class='m-20 btn-new'>Crear nuevo usuario </button>
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
