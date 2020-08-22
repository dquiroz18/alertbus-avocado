<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}">

    <title>AlertBus</title>

	<!-- Tab Icon -->  
    <link rel="icon" type="image/png" href="{{ url('login_/images/icons/favicon.png') }}"/>
    <!-- Bootstrap -->
    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
    <style>
      .breadcrumbs{
        background: #d6d6d6;
        color: #0064c9;
        margin-top: 20px;
        margin-bottom: 20px;
        padding: 10px;
      }
      .breadcrumbs .active {
        text-decoration: none;
        font-weight: bold;
      }
      table th, table td{
        font-size: 12px;
      }
      table th {
        background: #2A3F54;
        color: white;
        font-weight: bold;
        text-align: center;
      }
      #alert-close {
        float: right;
        background: transparent;
        color: black;
      }
      .table {
        margin-bottom: 0px !important;
      }
    </style>
    @yield('style')
    @yield('script_header')
  </head>

<div class="loading" style="position: absolute; width: 100vw; height: 100vh; overflow: hidden; background: rgba(146, 123, 100, 0.3); z-index: 999999999999; display: none;">
    <img src="{{ asset('images/loading.gif') }}" style="position: relative; left: 50vw; top: 45vh; width: 10vw">
</div>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{ url('home') }}" class="site_title"> <span>AlertBus</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{ asset('images/img.jpg') }}" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bienvenido,</span>
                <h2>{{ Auth::user()->nombre }}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menu</h3>
                <ul class="nav side-menu">
           @if (Auth::user()->tipo=='E' || Auth::user()->tipo=='A')        
                  <li><a><i class="fa fa-check"></i> Operaciones <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    
        						<li id="programar_viajes"><a href="{{ url('viajes/programar') }}">Programar Viajes</a></li>
                    <li id="importar_programacion_viajes"><a href="{{ url('viajes/programar/importar') }}">Importar Programación</a></li>
        						<li id="copiar_programados_viajes"><a href="{{ url('viajes/programados/copiar') }}">Copiar Programación</a></li>
                    </ul>
                  </li>
          @endif                               
                  <li><a><i class="fa fa-files-o"></i> Reportes <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					            <li id="programados_viajes"><a href="{{ url('viajes/programados') }}">Viajes Programados</a></li>
                      <li id="reporte_personal"><a href="{{ url('reportes/viajes') }}">Viajes Realizados</a></li>
                      <!-- <li id="reporte_personal"><a href="{{ url('reportes/viaje-personal') }}">Manifiesto</a></li> -->
					           <li id="reporte_personal"><a href="{{ url('reportes/viajes-liquidacion') }}">Liquidación</a></li>                  
                    </ul>
                  </li>
                  @if (Auth::user()->tipo=='E' || Auth::user()->tipo=='A')        
                  <li><a><i class="fa fa-gear"></i> Mantenimiento <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li id="reporte_personal"><a href="{{ url('mantenimiento/trabajadores') }}">Trabajador</a></li>
                      <li id="reporte_personal"><a href="{{ url('mantenimiento/centro-costos') }}">Centro Costo</a></li>
                      <li id="reporte_personal"><a href="{{ url('mantenimiento/proveedores') }}">Transportista</a></li>                      
                      <li id="reporte_personal"><a href="{{ url('mantenimiento/conductores') }}">Conductor</a></li>
                      <li id="reporte_personal"><a href="{{ url('mantenimiento/vehiculos') }}">Vehículo</a></li>
                      <li id="reporte_personal"><a href="{{ url('mantenimiento/rutas') }}">Ruta</a></li>
                      <li id="reporte_personal"><a href="{{ url('mantenimiento/tarifas') }}">Configuración Tarifa</a></li>      
                      <!-- <li id="reporte_personal"><a href="{{ url('mantenimiento/sincronizacion') }}">Sincronizacion</a></li> -->      
                    </ul>
                  </li>
                  <li><a><i class="fa fa-lock"></i> Seguridad <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li id="st_usuarios_web"><a href="{{ url('usuarios/web') }}">Usuarios Web</a></li>
                      <li id="st_usuarios_movil"><a href="{{ url('usuarios/movil') }}">Usuarios Móvil</a></li>
                    </ul>
                  </li>
                  @endif 
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/img.jpg') }}" alt="">{{ Auth::user()->nombre }}
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="{{ url('logout') }}"><i class="fa fa-sign-out pull-right"></i> Cerrar Sesión</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main" style="min-height: 100vh;">
            @yield('main-content')
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Copyright © 2019 | IBAO PERU
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>    
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ asset('build/js/custom.min.js') }}"></script>
    <script>
      function setMenu(selector) {
        $(selector).parent().parent().addClass('active');
        $(selector).parent().css('display', 'block');
        $(selector).addClass('current-page');
      }
      
      $('#alert-close').click(function(){
        $('#alert').hide();
      });
      @if ( ! ( Request::is('reportes/viajes') || Request::is('reportes/viajes/detalle*') || Request::is('reportes/viajes/tracking*')  ))
        localStorage.removeItem('data');
      @endif
    </script>
    @yield('script')
  </body>
</html>