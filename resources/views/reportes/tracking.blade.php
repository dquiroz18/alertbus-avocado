@extends('layouts.layout')

@section('main-content')
<style type="text/css">
  /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
     
</style>
	<div class="col-sm-12">
	    <div class="row">
	       <div class="col-xs-12">
	           <div class="breadcrumbs">
	               <span>Reportes</span>
	               <span> >> </span>
	               <span><a href="{{ url('reportes/viajes/') }}">Viajes Realizados</a></span>
	               <span> >> </span>
	               <span class="active">Tracking</span>
	           </div>
	       </div>
	    </div>
	    <div class="x_panel">
        	<div class="x_title">
	            <h2>Tracking</h2>
	            <ul class="nav navbar-right panel_toolbox">
	            	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
	            <div class="clearfix"></div>
          	</div>
        	<div class="x_content">
        		<div class="row">
        			<div class="col-sm-6"><h2>Fecha: {{ $detalle->fecha }}</h2></div>
        			<div class="col-sm-6"><h2>Transportista: {{ $detalle->nombreProveedor }}</h1></div>
        		</div>
        		<div class="row">
        			<div class="col-sm-6"><h2>Ruta: {{ $detalle->nombreRuta }}</h2></div>
        			<div class="col-sm-6"><h2>Placa: {{ $detalle->placaVehiculo }}</h2></div>
        		</div>
        		<br>
        		<br>
        		<br>
			    <iframe src="{{ url('tracking_iframe').'/'.$id }}" width="80%" height="600px"></iframe>
            </div>
        </div>
	</div>
@endsection

@section('script')
@endsection