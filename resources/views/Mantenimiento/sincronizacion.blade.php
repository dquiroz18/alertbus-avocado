@extends('layouts.layout')

@section('main-content')
	<div>
	    <div class="row">
	       <div class="col-xs-12">
	           <div class="breadcrumbs">
	               <span>Mantenimiento</span>
	               <span> >> </span>
	               <span class="active">Sincronizacion</span>
	           </div>
	       </div>
	    </div>
	    <div class="row" id="alert" style="display: none;">
	    	<div class="col-sm-12">
	    		<div class="alert alert-success">
	            	<button type="button" id="alert-close">×</button>
	            	<h4><i class="icon fa fa-check"></i> Mensaje</h4>
	            	<span id="alert-message"></span>
	         	</div>
	    	</div>
	    </div>
		<div class="row">
			<div class="col-sm-12">
				<div class="x_panel">
		        	<div class="x_title">
		        		<a target="_blank" href="{{ url('soap/trabajadores-request') }}" class="btn btn-primary">Sincronizar Trabajadores (NISIRA)</a>
		        		<a target="_blank" href="{{ url('soap/enviar-marcaciones') }}" class="btn btn-primary">Enviar Marcaciones (NISIRA)</a>
		        	</div>
		        </div>
			</div>
		</div>  
	</div>
@endsection
