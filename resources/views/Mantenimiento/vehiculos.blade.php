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
	               <span class="active">Vehículo</span>
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
		        		<h3>Listado de Vehículos</h3>
		        		<div class="row">
		        			<div class="col-sm-4">
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
		        			<div class="col-sm-4" id="showNewVehiculo">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new"><i class="fa fa-plus"></i> Agregar Vehículo</button>
		        			</div>
		        		</div>
		        		<div class="clearfix"></div>
		        	</div>
		        	<div class="x_content">
				        <table class="table table-hover table-striped table-bordered" id="tableManagment">
				            <thead>
				                <tr>
				                	<th width="300px">Transportista</th>
				                    <th>Placa</th>
				                    <th>Tipo Vehículo</th>
				                    <th>Capacidad</th>
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
	       	<h3 class="modal-title" style="color: red; font-weight: bold;">Eliminar VehÍculo</h3>
	      </div>
	      <form>
	      	<input type="hidden" name="id" id="txtIdE">
	      <div class="modal-body">
	        <p>
	        	¿Desea eliminar el Vehículo?
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
	       	<h3 class="modal-title" style="font-weight: bold;">Datos del Vehículo</h3>
	      </div>
	      <div class="modal-body" style="overflow: hidden;">
	      	<form>
	      		<input type="hidden" name="id" id="txtIdN">
	      		<div class="row">
	      			<div class="col-sm-4">
        				<div class="form-group">
        					<label>Transportista</label><br>
        					<select id="cmbTransportistaM" class="form-control" name="transportista" style="width: 100%">
        						<option value="0">Seleccione</option>
        						@foreach ($transportistas as $transp)
        							@if (Auth::user()->idProveedor != $transp->idProveedor)
        								<option value="{{ $transp->idProveedor }}">{{ $transp->razonSocial }}</option>	
        							@endif
        						@endforeach	
        					</select>
        				</div>
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
		            <div class="form-group col-sm-4">
		              <label for="txtPlaca">Placa</label>
		              <input type="text" class="form-control" id="txtPlaca" maxlength="7" name="placa" required>
		            </div>
		            <div class="form-group col-sm-4">
		              <label for="txtCapacidad">Capacidad</label>
		              <input type="number" class="form-control" id="txtCapacidad" max="99" maxlength="2" name="capacidad" required>
		              <div class="checkbox">
		              	<label><input type="checkbox" id="flagCapacidad" name="flag" value="1">¿Otra Capacidad?</label>
		              </div>
		            </div>
		            <div class="form-group col-sm-4">
		              <label for="txtCapacidadCovid">Capacidad Sugerida</label>
		              <input type="number" class="form-control" id="txtCapacidadCovid" max="99" maxlength="2" name="covid" required readonly>
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
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<script>
		$('#cmbTransportista').select2();
		$('#cmbTransportistaM').select2({
			dropdownParent: $('#new')
		});
	</script>
	<script>
		var centerColumns = [0, 2, 3, 4, 5];
	</script>
	@include('helpers.dataManagment')
	<script>
		$('#txtCapacidad').keyup(function() {
			var string = $(this).val();
			if (string.length > 2) {
				var forcedString = string.substr(0, 2);
				$(this).val(forcedString);
			}
			verificarCapacidadCovid();
		});
		$('#txtCapacidadCovid').keyup(function() {
			var string = $(this).val();
			if (string.length > 2) {
				var forcedString = string.substr(0, 2);
				$(this).val(forcedString);
			}
		});
		function verificarCapacidadCovid(){
			if ($('#flagCapacidad').is(':checked')) {
				$('#flagCapacidad').val('1');
				$('#txtCapacidadCovid').removeAttr('readonly');
				var valorActual = parseInt($('#txtCapacidad').val());
				var valorCovid = parseInt((valorActual/2));
				$('#txtCapacidadCovid').val(valorCovid);
			}
			else{
				$('#flagCapacidad').val('0');
				$('#txtCapacidadCovid').attr('readonly', 'readonly');
				$('#txtCapacidadCovid').val('0');
			}
		}
		$('#flagCapacidad').click(function() {
			verificarCapacidadCovid();
		});
		$('#buscar').click(function() {
		  	var o_id = $(this).parent().prev().find('select').val();
		  	data = getModelByParams({idProveedor: o_id}, "{{ url('mantenimiento/vehiculos/listar') }}", 'GET');
		  	listarOnTable(3, 5, data, [0, 2, 3], true, true, false);
		});

		$('#cmbTransportistaM').change(function() {
			var idProveedor = $(this).val();
			var tipoVehiculos = getModelByParams({idProveedor: idProveedor}, "{{ url('mantenimiento/vehiculos/tipo-vehiculos') }}", 'GET');
			var select = $('#cmbTipoVehiculo');
			listarOnSelect(0, 2, tipoVehiculos, select);
		});

		var recentlyAdded = false;

		$('#addTipoVehiculo').click(function() {
			var idProveedor = $('#cmbTransportistaM').val();
			if (idProveedor == '0') {
				alert("Seleccione un Transportista");
				return;
			}
			var tipoVehiculo = prompt("Nuevo Tipo Vehículo: ", "Ejem. Bus");
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
					$('#cmbTipoVehiculo').after('<a href="#" class="tpDelete" data-proveedor="'+idProveedor+'" data-tp="'+tipoVehiculo+'">Eliminar Tipo Vehículo '+tipoVehiculo+'</a>');
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

		$('#new').on('show.bs.modal', function() {
			$('.tpDelete').remove();
			if (id != 0) {
				var model = getModelByParams({idVehiculo: id}, "{{ url('mantenimiento/vehiculo') }}", 'GET');
				$('#cmbTransportistaM').val(model.idProveedor);
				$('#cmbTransportistaM').trigger('change');
				$('#cmbTipoVehiculo').val(model.idTipoVehiculo);
				$('#txtPlaca').val(model.placaVehiculo);
				$('#txtCapacidad').val(model.capacidad);
				if (model.flag == 1) {
					$('#flagCapacidad').prop('checked', true);
				}
				else{
					$('#flagCapacidad').prop('checked', false);	
				}
				verificarCapacidadCovid();
				$('#txtCapacidadCovid').val(model.capacidad_covid);
				$('#txtIdN').val(model.idVehiculo);
			}
			else {
				$('#new form').trigger('reset');
				$('#cmbTipoVehiculo').html('<option value="0">Seleccione</option>');
				$('#txtIdN').val('');
			}
		});

		$('#delete').on('show.bs.modal', function () {
			$('#txtIdE').val(id);
		})

		$('#new form').submit(function(e) {
		  	e.preventDefault();
		  	if ($('#cmbTransportistaM').val() == 0) {
		  		alert('Seleccione un Transportista');
		  		return false;
		  	}
		  	if ($('#cmbTipoVehiculo').val() == 0) {
		  		alert('Seleccione un Tipo Vehiculo');
		  		return false;
		  	}
		  	var data = $(this).serialize();
		  	//console.log(data);
		  	if(response = saveModel(data, "{{ url('mantenimiento/vehiculo') }}", 'POST')){
		  		var message = response.message;
		  		var success = response.success;
		  		showMessage(success, message);
		  		$('#buscar').trigger('click');
		  		$('#new form').trigger('reset');
				$('#new').modal('hide');
		  	}
		  	else {
					$('#alert-message').text("Error al guardar Vehículo. Contacte con Soporte");
					$('#alert').show();
					$('#new').modal('hide');
		  	}
		  });

	  $('#delete form').submit(function(e) {
	  	e.preventDefault();
	  	var data = $(this).serialize();
	  	//console.log(data);
	  	if(response = saveModel(data, "{{ url('mantenimiento/vehiculo/delete') }}", 'POST')){
	  		var message = response.message;
	  		var success = response.success;
	  		showMessage(success, message);
	  		$('#buscar').trigger('click');
	  		$('#delete form').trigger('reset');
			$('#delete').modal('hide');
	  	}
	  	else {
				$('#alert-message').text("Error al guardar el Vehículo. Contacte con Soporte");
				$('#alert').show();
				$('#delete').modal('hide');
	  	}
	  });

	  $('#delete, #new').on('hide.bs.modal', function(){
	  	id = 0;
	  });
	</script>
@endsection