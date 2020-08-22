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
	               <span class="active">Configuración Tarifa</span>
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
		        		<h3>Listado de Tarifas</h3>
		        		<div class="row">
		        			<div class="col-sm-4" style="display: none;">
		        				<div class="form-group">
		        					<label>Transportista</label>
		        					<select id="cmbTransportista" class="form-control">
		        						<option value="0">Seleccione</option>
		        						@foreach ($transportistas as $transp)
					          				@if (Auth::user()->idProveedor != $transp->idProveedor)
        										<option value="{{ $transp->idProveedor }}">{{ $transp->razonSocial }}</option>	
        									@endif
		        						@endforeach	
		        					</select>
		        				</div>
		        			</div>
		        			<div class="col-sm-2">
		        				<br>
										<button type="button" id="buscar" class="btn btn-primary"><i class="fa fa-search"></i> Filtrar</button>
		        			</div>
		        			<div class="clearfix"></div>
		        			<div class="col-sm-4" id="showNewTarifa">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new"><i class="fa fa-plus"></i> Agregar Tarifa</button>
		        			</div>
		        		</div>
		        		<div class="clearfix"></div>
		        	</div>
		        	<div class="x_content">
				        <table class="table table-hover table-striped table-bordered" id="tableManagment">
				            <thead>
				                <tr>
				                    <th>Ruta</th>
				                    <th width="90px">Tipo Vehículo</th>
				                    <th width="90px">Precio</th>
				                    <th width="120px">Desde</th>
				                    <th width="120px">Hasta</th>
				                    <th width="80px">Ver/Editar</th>
				                    <th width="80px">Eliminar</th>
				                </tr>
				            </thead>
				        </table>
		        	</div>
		        </div>
			</div>
		</div>  
	</div>

	<!-- delete ceco -->
	<div class="modal fade" tabindex="-1" role="dialog" id="delete">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       	<h3 class="modal-title" style="color: red; font-weight: bold;">Eliminar Tarifa</h3>
	      </div>
	      <form>
	      	<input type="hidden" name="id" id="txtIdE">
	      <div class="modal-body">
	        <p>
	        	¿Desea eliminar la Tarifa?
	        </p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" id="btn-delete" class="btn btn-danger">Eliminar</button>
	       </form>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	 <!-- Nuevo ceco -->
	<div class="modal fade" tabindex="-1" role="dialog" id="new">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       	<h3 class="modal-title" style="font-weight: bold;">Datos de la Tarifa</h3>
	      </div>
	      <div class="modal-body" style="overflow: hidden;">
	      	<form>
	      		<input type="hidden" name="id" id="txtIdN">
	      		<div class="row">
	      			<div class="col-sm-4" style="display: none;">
        				<div class="form-group">
        					<label>Transportista</label>
        					<select id="cmbTransportistaM" class="form-control" name="transportista">
        						<option value="0">Seleccione</option>
        						@foreach ($transportistas as $transp)
        							@if (Auth::user()->idProveedor != $transp->idProveedor)
        								<option value="{{ $transp->idProveedor }}">{{ $transp->razonSocial }}</option>	
        							@endif
        						@endforeach	
        					</select>
        				</div>
        			</div>
        			<div class="col-sm-4">
        				<label>Ruta</label>
        				<select name="ruta" id="cmbRuta" class="form-control">
        					<option value="0">Seleccione</option>
        				</select>
        			</div>
        			<div class="col-sm-4" id="divTipoVehiculo">
        				<label>Tipo Vehículo</label>
        				<select name="tipoVehiculo" id="cmbTipoVehiculo" class="form-control">
        					<option value="0">Seleccione</option>
        				</select>
        			</div>
        			<div class="col-sm-1">
        				<br>
        				<button type="button" class="btn btn-primary" title="Agregar una opcion más" id="addTipoVehiculo"><i class="fa fa-plus"></i></button>
        			</div>
	      		</div>
	      		<div class="row">
	      			<div class="col-sm-4" id="divTipoTarifa" style="display: none;">
        				<label>Tipo Tarifa</label>
        				<select name="tipoTarifa" id="cmbTipoTarifa" class="form-control">
        					<option value="0">Seleccione</option>
        				</select>
        			</div>
        			<div class="col-sm-1" style="display: none;">
        				<br>
        				<button type="button" class="btn btn-primary" title="Agregar una opcion más" id="addTipoTarifa"><i class="fa fa-plus"></i></button>						
        			</div>
	      		</div>
	      		<div class="row">
		            <div class="form-group col-sm-4">
		              <label for="txtPrecio">Precio</label>
		              <input type="number" class="form-control" id="txtPrecio" maxlength="12" name="precio" required>
		            </div>
		            <div class="form-group col-sm-4">
		              <label for="txtDesde">Desde</label>
		              <input type="date" class="form-control" id="txtDesde" name="desde" >
		            </div>
		            <div class="form-group col-sm-4">
		              <label for="txtHasta">Hasta</label>
		              <input type="date" class="form-control" id="txtHasta" name="hasta">
		            </div>
		      	</div>
	      </div>
	      <div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        	<button type="submit" id="btn-new" class="btn btn-primary">Guardar</button>
	       	</form>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

@endsection

@section('script')
	<script>
		var centerColumns = [0, 2, 3, 4, 5, 6, 7];
	</script>
	@include('helpers.dataManagment')
	<script>
		$('#buscar').click(function() {
	  	var o_id = $(this).parent().prev().find('select').val();
	  	data = getModelByParams({idProveedor: o_id}, "{{ url('mantenimiento/tarifas/listar') }}", 'GET');
	  	listarOnTable(5, 8, data, [0, 1, 3, 5], true, true, false);
	  });

		$('#cmbTransportistaM').change(function() {
			var idProveedor = $(this).val();
			var rutas = getModelByParams({idProveedor: idProveedor, combo: 1}, "{{ url('mantenimiento/rutas/listar') }}", 'GET');
			var select = $('#cmbRuta');
			listarOnSelect(0, 1, rutas, select);
			var tipoVehiculos = getModelByParams({idProveedor: idProveedor}, "{{ url('mantenimiento/vehiculos/tipo-vehiculos') }}", 'GET');
			var select = $('#cmbTipoVehiculo');
			listarOnSelect(0, 2, tipoVehiculos, select);
			var tipoTarifas = getModelByParams({idProveedor: idProveedor}, "{{ url('mantenimiento/tarifas/tipo-tarifas') }}", 'GET');
			var select = $('#cmbTipoTarifa');
			listarOnSelect(0, 3, tipoTarifas, select);
		});

		$('#addTipoVehiculo').click(function() {
			var idProveedor = $('#cmbTransportistaM').val();
			//if (idProveedor == '0') {alert("Seleccione un Transportista"); return false;}
			var tipoVehiculo = prompt("Nuevo Tipo Vehiculo: ", "Ejem. Bus");
			if (tipoVehiculo == null) {
				alert("Ingrese un nombre válido");
				return;
			}
			if (response = saveModel({idProveedor: 0, tipoVehiculo: tipoVehiculo}, "{{ url('mantenimiento/vehiculos/tipo-vehiculo') }}", 'POST')){
				var message = response.message;
				var success = response.success;
				alert(message);
				if (success == '0') {
					return;
				}
				else {
					$('#cmbTransportistaM').trigger('change');
					$('#cmbTipoVehiculo').find('option:last').prop('selected', 'selected');
					$('#cmbTipoVehiculo').after('<a href="#" class="tpDelete" data-proveedor="'+idProveedor+'" data-tp="'+tipoVehiculo+'">Eliminar el Tipo Vehículo '+tipoVehiculo+'</a>');
				}
			}

		});

		$('#divTipoVehiculo').on('click', '.tpDelete', function(e) {
			e.preventDefault();
			var tipoVehiculo = $(this).data('tp');
			var idProveedor = $(this).data('proveedor');
			if (response = saveModel({tipoVehiculo: tipoVehiculo, idProveedor: idProveedor}, "{{ url('mantenimiento/vehiculos/tipo-vehiculo/delete') }}", 'POST')) {
				var message = response.message;
				var success = response.success;
				alert(message);
				if (success == '0') {
					return;
				}
				else {
					$('#cmbTransportistaM').trigger('change');
					$(this).hide();
				}
			}
		});

		$('#addTipoTarifa').click(function() {
			var idProveedor = $('#cmbTransportistaM').val();
			var tipoTarifa = prompt("Nuevo Tipo Tarifa: ", "Ejem. Bus");
			if (tipoTarifa == null) {
				alert("Ingrese un nombre válido");
				return;
			}
			if (response = saveModel({idProveedor: 0, tipoTarifa: tipoTarifa}, "{{ url('mantenimiento/tarifas/tipo-tarifa') }}", 'POST')){
				var message = response.message;
				var success = response.success;
				alert(message);
				if (success == '0') {
					return;
				}
				else {
					$('#cmbTransportistaM').trigger('change');
					$('#cmbTipoTarifa').find('option:last').prop('selected', 'selected');
					$('#cmbTipoTarifa').after('<a href="#" class="tpDelete" data-proveedor="'+idProveedor+'" data-tp="'+tipoTarifa+'">Eliminar el Tipo Tarifa '+tipoTarifa+'</a>');
				}
			}
		});

		$('#divTipoTarifa').on('click', '.tpDelete', function(e) {
			e.preventDefault();
			var ruta = $('#cmbRuta').val();
			var tipoVehiculo = $('#cmbTipoVehiculo').val();
			var tipoTarifa = $(this).data('tp');
			var idProveedor = $(this).data('proveedor');
			if (response = saveModel({tipoTarifa: tipoTarifa, idProveedor: idProveedor}, "{{ url('mantenimiento/tarifas/tipo-tarifa/delete') }}", 'POST')) {
				var message = response.message;
				var success = response.success;
				alert(message);
				if (success == '0') {
					return;
				}
				else {
					$('#cmbTransportistaM').trigger('change');
					$('#tipoVehiculo').val(tipoVehiculo);
					$('#cmbRuta').val(ruta);
					$(this).hide();
				}
			}
		});

		$('#new').on('show.bs.modal', function() {
			$('.tpDelete').remove();
			if (id != 0) {
				var model = getModelByParams({idTarifa: id}, "{{ url('mantenimiento/tarifa') }}", 'GET');
				$('#cmbTransportistaM').val(model.idProveedor);
				$('#cmbTransportistaM').trigger('change');
				$('#cmbRuta').val(model.idRuta);
				$('#cmbTipoVehiculo').val(model.idTipoVehiculo);
				//$('#cmbTipoTarifa').val(model.idTipoTarifa);
				$('#txtPrecio').val(model.precio);
				if (model.desde != null) $('#txtDesde').val(model.desde.substring(0, 10));
				if (model.hasta != null) $('#txtHasta').val(model.hasta.substring(0, 10));
				$('#txtIdN').val(model.idTarifa);
			}
			else {
				$('#new form').trigger('reset');
				$('#cmbTransportistaM').val('0');
				$('#cmbTransportistaM').trigger('change');
				$('#txtIdN').val('');
			}
		});

		$('#delete').on('show.bs.modal', function () {
			$('#txtIdE').val(id);
		})

		$('#new form').submit(function(e) {
		  	e.preventDefault();
		  	/*if ($('#cmbTransportistaM').val() == 0) {
		  		alert('Seleccione un Transportista');
		  		return false;
		  	}*/
		  	if ($('#cmbTipoVehiculo').val() == 0) {
		  		alert('Seleccione un Tipo Vehiculo');
		  		return false;
		  	}
		  	if ($('#cmbRuta').val() == 0) {
		  		alert('Seleccione una Ruta');
		  		return false;
		  	}
		  	var data = $(this).serialize();
		  	//console.log(data);
		  	if(response = saveModel(data, "{{ url('mantenimiento/tarifa') }}", 'POST')){
		  		var message = response.message;
		  		var success = response.success;
		  		showMessage(success, message);
		  		$('#buscar').trigger('click');
		  		$('#new form').trigger('reset');
					$('#new').modal('hide');
		  	}
		  	else {
					$('#alert-message').text("Error al guardar Tarifa. Contacte con Soporte");
					$('#alert').show();
					$('#new').modal('hide');
		  	}
		  });

	  $('#delete form').submit(function(e) {
	  	e.preventDefault();
	  	var data = $(this).serialize();
	  	//console.log(data);
	  	if(response = saveModel(data, "{{ url('mantenimiento/tarifa/delete') }}", 'POST')){
	  		var message = response.message;
	  		var success = response.success;
	  		showMessage(success, message);
	  		$('#buscar').trigger('click');
	  		$('#delete form').trigger('reset');
				$('#delete').modal('hide');
	  	}
	  	else {
				$('#alert-message').text("Error al guardar Tarifa. Contacte con Soporte");
				$('#alert').show();
				$('#delete').modal('hide');
	  	}
	  });

	  $('#delete, #new').on('hide.bs.modal', function(){
	  	id = 0;
	  });
	</script>
@endsection