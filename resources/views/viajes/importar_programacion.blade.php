@extends('layouts.layout')

@section('main-content')
	<style>
		.table {
			margin-bottom: 0px !important;
		}
	</style>
	<div>
	    <div class="row">
	       <div class="col-xs-12">
	           <div class="breadcrumbs">
	               <span>Operaciones</span>
	               <span> >> </span>
	               <span class="active"><a href="#">Importar Programacion</a></span>
	           </div>
	       </div>
	    </div>
	    @if (session('message'))
			<div class="alert alert-success alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <h4><i class="icon fa fa-check"></i> Mensaje</h4>
	            {!! session('message') !!}
	         </div>
		@endif
		<div class="row">
			<div class="col-sm-12">
				<div class="x_panel">
		        	<div class="x_title">
		        		<div class="row">
		        			<div class="col-sm-3">
		        				<a href="{{ url('viajes/plantilla/descargar') }}" target="_blank" class="btn btn-info" id="sinc_s360"><i class="fa fa-file-excel-o"></i> Descargar Plantilla</a>
		        			</div>
		        			<div class="col-sm-7">
		        				<form action="{{ url('viajes/plantilla/subir') }}" method="post" enctype="multipart/form-data">
		        					{{ csrf_field() }}
		        					<div class="col-sm-6">
		        						<input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xlsm,.xlst">	
		        					</div>
		        					<div class="col-sm-6">
		        						<button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Subir Data</a>	
		        					</div>
		        				</form>
		        			</div>
		        		</div>
		        		<div class="clearfix"></div>
		        	</div>
		        </div>
			</div>
		</div>
		        
	</div>
@endsection