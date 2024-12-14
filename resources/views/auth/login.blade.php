<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel ="stylesheet" href= "{{asset('storage/css/bootstrap.min.css')}}">
        <link rel ="stylesheet" href= "{{asset('css/login.css')}}">

        <title>Laravel</title>

    </head>

<div class="body-AW-login">
	<div class="main-login">
			<div class="signup">
                    <div class="d-flex">
                        <img class="AW-logo-login mt-5 m-auto" src="{{asset('img/1a_logotype.png')}}">
                                </div>
                    <label  class="label-login">Log In</label>
                        <div class="text-center text-light"> panel de administración </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="d-flex">
                                <div class="w-75 m-auto">
                                    <input id="user" type="text" class=" @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus placeholder="Login">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex">

                                <div class="w-75 m-auto">
                                    <input id="password" type="password" class=" @error('password') is-invalid @enderror" name="password" required placeholder="Password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-2">
                                    <button type="submit">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
			</div>
	</div>
</div>

</html>
