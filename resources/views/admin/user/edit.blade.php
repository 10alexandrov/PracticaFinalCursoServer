@extends('plantilla.plantilla')
@section('contenido')

        <div class="info-container">
            <div class="d-flex justify-content-between">
                <h1> Editar usuario</h1>
                <a  href="{{ route('users.index')}}">
                    <button class='btn btn-primary mt-2 me-2'>Volver </button>
                </a>
            </div>

            <div class="form">
                <div class="container mt-2">
                    <div class="table_container-edit">

                        <form class="w-85" action="{{ route('users.update', $usuario->usuario_id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row m-10">
                                <div class="form-group col-12 col-md-7">
                                    <label for="u_nombre">Nombre usuario</label>
                                    <input type="text" class="form-control" id="u_nombre" name="u_nombre" value="{{ $usuario->u_nombre }}">
                                </div>
                                <div class="form-group col-12 col-md-4 p-mobile">
                                    @if ($errors->has('u_nombre'))
                                        <div class="text-danger">
                                            {{ $errors->first('u_nombre')}}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row m-10">
                                <div class="form-group col-12 col-md-7">
                                    <label for="u_login">Login</label>
                                    <input type="text" class="form-control" id="u_login" name="u_login" value="{{ $usuario->u_login }}">
                                </div>
                                <div class="form-group col-12 col-md-4 p-mobile">
                                    @if ($errors->has('u_login'))
                                        <div class="text-danger">
                                            {{ $errors->first('u_login')}}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row m-10">
                                <div class="form-group col-12 col-md-7">
                                    <label for="u_password">Password</label>
                                    <input type="password" class="form-control" id="u_password" name="u_password">
                                </div>
                                <div class="form-group col-12 col-md-4 p-mobile">
                                    @if ($errors->has('u_password'))
                                        <div class="text-danger">
                                            {{ $errors->first('u_password')}}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row m-10">
                                <div class="form-group col-12 col-md-7">
                                    <label for="u_password2">Repite password</label>
                                    <input type="password" class="form-control" id="u_password2" name="u_password2">
                                </div>
                                <div class="form-group col-12 col-md-4 p-mobile">
                                    @if ($errors->has('u_password2'))
                                        <div class="text-danger">
                                            {{ $errors->first('u_password2')}}
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="row m-10">
                                <div class="form-group col-12 col-md-7">
                                    <label for="u_role">Rol</label>
                                    <select class="w-100" name="u_role" id="u_role" class="form-control" required>
                                        <option value="recogedor" {{ $usuario->u_role == 'recogedor' ? 'selected' : '' }}>Recogedor</option>
                                        <option value="admin" {{ $usuario->u_role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="manager" {{ $usuario->u_role == 'manager' ? 'selected' : '' }}>Manager</option>
                                        <option value="cliente" {{ $usuario->u_role == 'cliente' ? 'selected' : '' }}>Cliente</option>
                                        <option value="vendedor" {{ $usuario->u_role == 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                                        <option value="receptor" {{ $usuario->u_role == 'receptor' ? 'selected' : '' }}>Receptor</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-4 p-mobile">
                                    @if ($errors->has('u_role'))
                                        <div class="text-danger">
                                            {{ $errors->first('u_role')}}
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="row m-10">
                                <div class="form-check col-12 col-md-3">
                                    <input class="form-check-input" name ="u_active" type="radio" value=1 id="activeTrue" {{ $usuario->u_active == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label form-label-AW" for="activeTrue">
                                    Usuario activo
                                    </label>
                                </div>

                                <div class="form-check col-12 col-md-4">
                                    <input class="form-check-input" type="radio" name ="u_active" value=0 id="activeFalse" {{ $usuario->u_active == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label form-label-AW" for="activeFalse">
                                        Usuario inactivo
                                    </label>
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    @if ($errors->has('u_active'))
                                        <div class="text-danger">
                                            {{ $errors->first('u_active')}}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <button class='m-10 btn btn-primary'>Editar usuario </button>
                         </form>
                    </div>
                </div>
            </div>
        </div>

@endsection
