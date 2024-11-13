<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel ="stylesheet" href= "{{asset('storage/css/bootstrap.min.css')}}">
        <link rel ="stylesheet" href= "{{asset('storage/style.css')}}">

        <title>Laravel</title>

    </head>


<style>
    .body-AW{
	margin: 0;
	padding: 0;
	display: flex;
	justify-content: center;
	align-items: center;
	min-height: 100vh;
	font-family: 'Jost', sans-serif;
	background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);
}
.main{
	width: 350px;
	height: 500px;
	background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);
	overflow: hidden;
	border-radius: 10px;
	box-shadow: 5px 20px 50px #000;
}
#chk{
	display: none;
}
.signup{
	position: relative;
	width:100%;
	height: 100%;
}
.label{
	color: #fff;
	font-size: 2.3em;
	justify-content: center;
	display: flex;
	margin: 20px;
	font-weight: bold;
	cursor: pointer;
	transition: .5s ease-in-out;
}

form label {
    font-size: 1em;
    color: #fff;
	justify-content: center;
	display: flex;
	font-weight: bold;
}
input{
	width: 60%;
	height: 10px;
	background: #e0dede;
	justify-content: center;
	display: flex;
	margin: 10px auto;
	padding: 12px;
	border: none;
	outline: none;
	border-radius: 5px;
}
button{
	width: 60%;
	height: 40px;
	margin: 10px auto;
	justify-content: center;
	display: block;
	color: #fff;
	background: #573b8a;
	font-size: 1em;
	font-weight: bold;
	margin-top: 10px;
	outline: none;
	border: none;
	border-radius: 5px;
	transition: .2s ease-in;
	cursor: pointer;
}
button:hover{
	background: #6d44b8;
}
.login{
	height: 460px;
	background: #eee;
	border-radius: 60% / 10%;
	transform: translateY(-180px);
	transition: .8s ease-in-out;
}
.login label{
	color: #573b8a;
	transform: scale(.6);
}

#chk:checked ~ .login{
	transform: translateY(-500px);
}
#chk:checked ~ .login label{
	transform: scale(1);
}
#chk:checked ~ .signup label{
	transform: scale(.6);
}

.AW-logo {
  width: 40%;
}

.AW-error {
  color: rgb(253, 119, 119);
  text-align: center;
}

</style>

<div class="body-AW">
	<div class="main">
			<div class="signup">
                    <div class="d-flex">
                        <img class="AW-logo mt-5 m-auto" src="https://omnigena.info/img/logo/1a_logotype.png">
                                </div>
                    <label  class="label">Log In</label>
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

                            <div class="form-check d-flex w-50">
                                <div class="m-auto">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
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
