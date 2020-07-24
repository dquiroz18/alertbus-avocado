<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
  <link rel="icon" type="image/png" href="{{ url('login_/images/icons/favicon.png') }}"/>
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ url('login_/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ url('login_/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ url('login_/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ url('login_/fonts/iconic/css/material-design-iconic-font.min.css') }}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ url('login_/vendor/animate/animate.css') }}">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="{{ url('login_/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ url('login_/vendor/animsition/css/animsition.min.css') }}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ url('login_/css/util.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('login_/css/main.css') }}">
<!--===============================================================================================-->
</head>
<style>
  .login100-more {
    background-image: url("{{ url('login_/images/bg.png') }}");    
  }
  .login100-more::before{
    background-color: #fff !important;
  }
  body {
    overflow: hidden;
  }
  form {
    position: relative;
    top: -50px;
  }
</style>
<body style="background-color: #999999;">
  
  <div class="limiter">
    <div class="container-login100">
      <div class="login100-more"></div>

      <div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">
        <form action="{{ url('login') }}" method="POST" class="login100-form validate-form">
            {{ csrf_field() }}
            @if (count($errors))
              <ul>
                  @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
            @endif
            <h2><img src="{{ url('login_/images/mission.png') }}" alt="" width="200px" height="120px"></h2> <br>
            <span class="login100-form-title p-b-59" style="margin-top: 30px; font-size: 30px; font-size: 18px;">
              Iniciar Sesión
            </span>
            
            <div class="wrap-input100 validate-input" data-validate="Usuario es obligatorio">
              <span class="label-input100">Usuario</span>
              <input class="input100" type="text" name="usuario" placeholder="nombre de usuario">
              <span class="focus-input100"></span>
            </div>

            <div class="wrap-input100 validate-input" data-validate = "Contraseña es obligatorio">
              <span class="label-input100">Contraseña</span>
              <input class="input100" type="password" name="password" placeholder="*************">
              <span class="focus-input100"></span>
            </div>

            <div class="container-login100-form-btn">
              <div class="wrap-login100-form-btn">
                <button class="login100-form-btn" type="submit"  style="background: #62b973;">
                    Iniciar Sesión
                  </button>
              </div>
            </div>
        </form>
        <br>
        <h6>Copyright © {{ date('Y') }} | IBAO PERU</h6>
      </div>
    </div>
  </div>
  
<!--===============================================================================================-->
  <script src="{{ asset('login_/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
  <script src="{{ asset('login_/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
  <script src="{{ asset('login_/vendor/bootstrap/js/popper.js') }}"></script>
  <script src="{{ asset('login_/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
  <script src="{{ asset('login_/js/main.js') }}"></script>

</body>
</html>