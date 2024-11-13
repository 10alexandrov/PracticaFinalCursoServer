@extends('plantilla.plantilla')
@section('contenido')

        <div class="info-container AW-center">
            <div class="d-flex justify-content-between">
                <h1> Editar usuario</h1>
                <a  href="{{ route('usuarios.index')}}">
                    <button class='btn btn-primary mt-2 me-2'>Volver </button>
                </a>
            </div>

            <div class="form">
                <div class="container mt-2">
                    <div class="table_container">

                        <form action="{{ route('usuarios.update', $usuario->usuario_id) }}" method="POST" enctype="multipart/form-data">
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
                                <input type="text" class="form-control" id="u_password" name="u_password" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="u_password">Repite password</label>
                                <input type="text" class="form-control" id="u_password" name="u_password" required>
                            </div>

                            <div class="form-group m-20">
                                <label for="u_role">Role</label>
                                <select class="w-100" name="u_role" id="u_role" class="form-control" required>
                                    <option value="recogedor" {{ $usuario->u_role == 'recogedor' ? 'selected' : '' }}>Recogedor</option>
                                    <option value="admin" {{ $usuario->u_role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="manager" {{ $usuario->u_role == 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="cliente" {{ $usuario->u_role == 'cliente' ? 'selected' : '' }}>Cliente</option>
                                    <option value="vendedor" {{ $usuario->u_role == 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                                    <option value="receptor" {{ $usuario->u_role == 'receptor' ? 'selected' : '' }}>Receptor</option>
                                </select>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name ="u_active" type="radio" value=1 id="activeTrue" {{ $usuario->u_active == 1 ? 'checked' : '' }}>
                                <label class="form-check-label form-label-AW" for="activeTrue">
                                   Usuario active
                                 </label>
                             </div>

                             <div class="form-check form-check-inline">
                                 <input class="form-check-input" type="radio" name ="u_active" value=0 id="activeFalse" {{ $usuario->u_active == 0 ? 'checked' : '' }}>
                                 <label class="form-check-label form-label-AW" for="activeFalse">
                                    Usuario inactive
                                  </label>
                             </div>

                             <button class='m-20 btn-new'>Editar usuario </button>
                         </form>
                    </div>
                </div>
            </div>
        </div>

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
        padding: 10px;
        background-color: #ccc;
    }

    .m-20 {
    margin-top: 15px;
    }
    label {
        font-weight:600;
    }
</style>
@endsection
