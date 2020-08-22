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
	               <span>Mantenimiento</span>
	               <span> >> </span>
	               <span class="active">Trabajador</span>
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
		        		<h3>Listado de Trabajadores</h3>
		        		<div class="row">
		        			<div class="col-sm-4">
		        				<div class="form-group">
		        					<label>Empresa</label>
		        					<select id="cmbEmpresa" class="form-control">
		        						@foreach ($empresas as $emp)
		        							@foreach (explode('-', Auth::user()->idEmpresa) as $idEmpresa)
		        								@if ( $idEmpresa == $emp->idEmpresa)
		        									<option value="{{ $emp->idEmpresa }}">{{ $emp->razonSocial }}</option>
		        								@endif	
		        							@endforeach
		        						@endforeach	
		        					</select>
		        				</div>
		        			</div>
		        			<div class="col-sm-2">
		        				<br>
								<button type="button" id="buscar" class="btn btn-primary"><i class="fa fa-search"></i> Filtrar</button>
		        			</div>
		        		</div>
		        		<div class="col-sm-10"></div>
		        		<div class="col-sm-2">
		        			<a href="{{ url('sap/trabajadores-request') }}" target="_blank" class="btn btn-success"><i class="fa fa-refresh"></i> Actualizar</a>
		        		</div>
		        		<div class="clearfix"></div>
		        		
		        	</div>
		        	<div class="x_content">
				        <table class="table table-hover table-striped table-bordered" id="tableManagment">
				            <thead>
				                <tr>
				                	<th width="200x">Empresa</th>
				                    <th>Tarjeta RFID</th>
				                    <th>Nro. Documento</th>
				                    <th width="300px">Trabajador</th>
				                    <th>Blacklist</th>
				                    <th>Estado</th>
				                </tr>
				            </thead>
				        </table>
		        	</div>
		        </div>
			</div>
		</div>  
	</div>

@endsection

@section('script')
	<script>
		var centerColumns = [0, 1, 2, 4, 5];
	</script>
	@include('helpers.dataManagment')
	<script>
		$('#buscar').click(function() {
	  		var o_id = $(this).parent().prev().find('select').val();
	  		data = getModelByParams({idEmpresa: o_id}, "{{ url('mantenimiento/trabajadores/listar') }}", 'GET');
	  		listarOnTable(0, 5, data, [0, 1], false, false, false);
	  });

	</script>
@endsection