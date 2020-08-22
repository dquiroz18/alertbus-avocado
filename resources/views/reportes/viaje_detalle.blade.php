@extends('layouts.layout')

@section('main-content')
	<div class="col-sm-12">
		<div class="row" id="alert" style="display: none;">
	    	<div class="col-sm-12">
	    		<div class="alert alert-success">
	            	<button type="button" id="alert-close">×</button>
	            	<h4><i class="icon fa fa-check"></i> Mensaje</h4>
	            	<span id="alert-message"></span>
	         	</div>
	    	</div>
	    </div>
	    @if (session('message'))
			<div class="alert alert-success alert-dismissible">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <h4><i class="icon fa fa-check"></i> Mensaje</h4>
	            {{ session('message') }}
	         </div>
		@endif
	    <div class="row">
	       <div class="col-xs-12">
	           <div class="breadcrumbs">
	               <span>Reportes</span>
	               <span> >> </span>
	               <span><a href="{{ url('reportes/viajes/') }}">Viajes Realizados</a></span>
	               <span> >> </span>
	               <span class="active">Detalle</span>
	           </div>
	       </div>
	    </div>
	     <div class="x_panel">
        	<div class="x_title">
	            <h2>Datos del Viaje</h2>
	            <ul class="nav navbar-right panel_toolbox">
	            	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
	            <div class="clearfix"></div>
          	</div>
        	<div class="x_content">
        		<form id="changeCabecera">
        		{{ csrf_field() }}
        		<input type="hidden" id="idViaje" name="idViaje">
        		<input type="hidden" id="idPlanificacion" name="idPlanificacion">
        		<div class="row">
        			<div class="form-group col-sm-3">
        				<label for="Empresa">Empresa</label>
						<select name="empresa" id="empresa" class="form-control disabled" disabled>
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="form-group col-sm-3" style="display: none;">
        				<label for="area">Area</label>
						<select name="area" id="area" class="form-control" disabled>
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="form-group col-sm-3">
        				<label for="centrocosto">Centro Costo</label>
						<select name="centrocosto" id="centrocosto" class="form-control" disabled>
							<option value="0">Seleccione</option>
						</select>
        			</div>
        		</div>
        		<div class="row">
        			<div class="form-group col-sm-3">
        				<label for="transportista">Transportista</label>
						<select name="transportista" id="transportista" class="form-control disabled" disabled>
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="form-group col-sm-3">
        				<label for="ruta">Ruta</label>
						<select name="ruta" id="ruta" class="form-control disabled" disabled>
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="form-group col-sm-3">
        				<label for="tipoVehiculo">Tipo Vehículo</label>
						<select name="tipoVehiculo" id="tipoVehiculo" class="form-control disabled" disabled>
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="form-group col-sm-3" style="display:none">
        				<label for="tipoViaje">Tipo Tarifa</label>
						<select name="tipoViaje" id="tipoViaje" class="form-control disabled" disabled>
							<option value="0">Seleccione</option>
						</select>
        			</div>
        		</div>
        		<div class="row">
        			<div class="form-group col-sm-3">
						<label for="vehiculo">Placa</label> 
						<select id="vehiculo" name="vehiculo" class="form-control">
							<option value="0">Seleccione</option>
						</select>
					</div>
					<div class="form-group col-sm-3">
						<label for="conductor">Conductor</label> 
						<select id="conductor" name="conductor" class="form-control">
							<option value="0">Seleccione</option>
						</select>
					</div>
					<div class="form-group col-sm-3">
						<label for="horaInicio">Hora Inicio</label> 
						<input id="horaInicio" name="horaInicio" class="form-control" type="time">
					</div>
					<div class="form-group col-sm-3">
						<label for="horaFin">Hora Fin</label> 
						<input id="horaFin" name="horaFin" class="form-control" type="time">
					</div>
        		</div>
        		<div class="row" id="hasEdit">
        			<div class="form-group col-sm-12">
						<button type="submit" id="edit" class="btn btn-warning">Guardar Cambios</button>
					</div>
        		</div>
        		</form>
        		<div class="row" id="btnAddWorkers">
        			<div class="form-group col-sm-12">
						<label>Agregar Trabajadores</label> <br>
						<button type="button" data-toggle="modal" data-target="#new" class="btn btn-primary"><i class="fa fa-plus"></i></button>
					</div>
        		</div>
            </div>
        </div>
	    <div class="x_panel">
        	<div class="x_title">
	            <h2>Detalle del Viaje</h2>
	            <ul class="nav navbar-right panel_toolbox">
	            	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
	            <div class="clearfix"></div>
          	</div>
        	<div class="x_content">
        		<table class="table table-hover table-striped table-bordered" id="tablaProgramacion">
		            <thead>
		                <tr>
		                	<th width="120px">Nro. Documento</th>
		                    <th width="300px">Trabajador</th>
		                    <th width="90px">Nro. Asiento</th>
		                    <th width="100px">Hora Subida</th>
		                    <th width="100px">Hora Bajada</th>
		                    <th>Restricción</th>
		                    @if (Auth::user()->tipo=="E")
		                    <th width="80px">Editar</th>
		                    <th width="80px">Eliminar</th>
		                    @endif
		                </tr>
		                <tbody>
		                	@foreach ($result as $row)
		                		<tr>
		                			<td>{{ $row->numeroDocumento }}</td>
		                			<td>{{ $row->nombreTrabajador }}</td>
		                			<td>{{ $row->nroAsiento }}</td>
		                			<td>{{ $row->horaIngreso }}</td>
		                			<td>{{ $row->horaSalida }}</td>
		                			<td>{{ $row->tipoSuspension }}</td>
		                			@if (Auth::user()->tipo=="E")
		                			<td><button class="btn btn-warning edit" data-toggle="modal" data-target="#new" data-id="{{ $row->idViajeDetalle }}"><i class="fa fa-edit"></i></button></td>
									<td><button class="btn btn-danger delete" data-toggle="modal" data-target="#delete" data-id="{{ $row->idViajeDetalle }}"><i class="fa fa-remove"></i></button></td>
		                			@endif
		                		</tr>
		                	@endforeach
		                </tbody>
		            </thead>
		        </table>
            </div>
        </div>
	</div>

	<!-- delete client -->
	<div class="modal fade" tabindex="-1" role="dialog" id="delete">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       	<h3 class="modal-title" style="color: red; font-weight: bold;">Eliminar Trabajador</h3>
	      </div>
	      <form action="{{ url('viajes/validacion/trabajador/delete') }}" method="POST">
	      	{{ csrf_field() }}
	      <div class="modal-body">
	        <p>
	        	¿Desea eliminar el Trabajador?
	        </p>
	        <input type="hidden" id="txtidViajeDetalleR" name="idViajeDetalle">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" class="btn btn-danger">Eliminar</button>
	       </form>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	 <!-- Nuevo client -->
	<div class="modal fade" tabindex="-1" role="dialog" id="new">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       	<h3 class="modal-title">Editar Trabajador</h3>
	      </div>
	      <div class="modal-body" style="overflow: hidden;">
	      	<form action="{{ url('viajes/validacion/trabajador/edit') }}" method="POST">
	      		<input type="hidden" id="txtidViajeDetalle" name="idViajeDetalle">
	      	{{ csrf_field() }}
	      	<div class="row">
		      	<div class="form-group col-sm-6">
                  <label>Nro. Documento</label>
                  <input type="number" maxlength="8" max="99999999" class="form-control" id="txtDoc" >
                </div>
	      	</div>
	      	<div class="row">
                <div class="form-group col-sm-8">
                	<label>Trabajador</label>
                	<input type="text" id="txtName" class="form-control" readonly>
                </div>
	      	</div>
	      	<div class="row">
	      		<div class="col-sm-12">
	      			<button type="button" class="btn btn-primary" id="add_horarios" data-index="0"><i class="fa fa-plus"></i> Agregar Subida y Bajada</button>
	      		</div>
	      		<div class="col-sm-12">
	      			<h4>Subida y Bajada</h4>
	      		</div>
	      		<div class="horarios">
	      			<table class="table table-striped table-bordered">
	      				<thead>
	      					<tr>
	      						<th>Hora Subida</th>
	      						<th>Hora Bajada</th>
	      						<th>Acción</th>
	      					</tr>
	      				</thead>
	      				<tbody id="horarios">
	      					@for ($i = 0; $i < 1; $i++)
	      						<tr id="tr{{ $i }}">
				    				<td>
				    					<div class="form-group">
				    						<label>Fecha</label>
				    						<div class="input-group" id="fecha_inicio_date{{ $i }}">
				    							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				    							<input type="date" id="fecha_inicio{{ $i }}" class="form-control" />
				    						</div>
				    					</div>
				    					<div class="form-group">
				    						<label>Hora</label>
				    						<div class="input-group" id="hora_inicio_date{{ $i }}">
				    							<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
				    							<input type="time" id="hora_inicio{{ $i }}" class="form-control" />
				    						</div>
				    					</div>
				    				</td>
				    				<td>
				    					<div class="form-group">
				    						<label>Fecha</label>
				    						<div class="input-group" id="fecha_fin_date{{ $i }}">
				    							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				    							<input type="date" id="fecha_fin{{ $i }}" class="form-control" />
				    						</div>
				    					</div>
				    					<div class="form-group">
				    						<label>Hora</label>
				    						<div class="input-group" id="hora_inicio_date{{ $i }}">
				    							<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
				    							<input type="time" id="hora_fin{{ $i }}" class="form-control" />
				    						</div>
				    					</div>
				    				</td>
				    				<td>
				    					<button type="button" data-viajedetalle_id="" class="btn btn-primary" id="save{{ $i }}" ><i class="fa fa-save"></i></button>
				    				</td>
			    			 	</tr>
	      					@endfor
	      				</tbody>
	      			</table>
	      		</div>
	      	</div>
			
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	       </form>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@endsection

@section('script')
	<script>
		$('#txtDoc').keyup(function() {
			var string = $(this).val();
			if (string.length > 8) {
				var forcedString = string.substr(0, 8);
				$(this).val(forcedString);
			}
		});
		@if (Auth::user()->tipo == 'T')
			$('#centrocosto').prop('disabled', true);
			$('#vehiculo').prop('disabled', true);
			$('#conductor').prop('disabled', true);
			$('#horaInicio').prop('disabled', true);
			$('#horaFin').prop('disabled', true);
			$('#btnAddWorkers').css('display', 'none');
		@endif
		var hasChanges = false;
		var tablaProgramacion = $('#tablaProgramacion').DataTable({
			"order": []
		});
		var empresas = {!! json_encode($empresas) !!};
		//var areas = {!! json_encode($areas) !!};
		var centrocostos = {!! json_encode($centrocostos) !!};
		var transportistas = {!! json_encode($transportistas) !!};
		var rutas = {!! json_encode($rutas) !!};
		var tiposVehiculos = {!! json_encode($tiposVehiculos) !!};
		var tiposViajes = {!! json_encode($tiposViajes) !!};
		var vehiculos = {!! json_encode($vehiculos) !!};
		var conductores = {!! json_encode($conductores) !!};
		var cabecera = {!! json_encode($cabecera) !!};

		@for ($i = 0; $i < 1; $i++)
		    $('#tr{{ $i }}').hide();

		    $('#fecha_inicio{{ $i }}').on('change', function() {
		    	$('#save{{ $i }}').prop('disabled', false);
		    });
			$('#fecha_fin{{ $i }}').on('change', function() {
				$('#save{{ $i }}').prop('disabled', false);
			});
			$('#hora_inicio{{ $i }}').on('keyup', function() {
		    	$('#save{{ $i }}').prop('disabled', false);
		    });
			$('#hora_fin{{ $i }}').on('keyup', function() {
				$('#save{{ $i }}').prop('disabled', false);
			});

			$('#save{{ $i }}').click(function(){
				var inicio = $('#fecha_inicio{{ $i }}').val() + ' ' + $('#hora_inicio{{ $i }}').val();
				var fin = $('#fecha_fin{{ $i }}').val() + ' ' + $('#hora_fin{{ $i }}').val();
				var viajedetalle_id = $(this).data('viajedetalle_id');
				$.ajaxSetup({
	              headers: {
	                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	              }
	            });
				if (viajedetalle_id) {
					$.ajax({
						url: "{{ url('viajes/validacion/trabajador/editHorario') }}",
						method: 'post',
						data: {
							idsViajeDetalle: id,
							idViajeDetalle: viajedetalle_id,
							inicio: inicio,
							fin: fin
						},
						success: function(response){
							alert(response.message);
							hasChanges = true;
						}
					});
				}
				else{
					var ndoc = $('#txtDoc').val();
					var idViaje = cabecera[0].idViaje;
					$.ajax({
						url: "{{ url('viajes/validacion/trabajador/addHorario') }}",
						method: 'post',
						data: {
							idViaje: idViaje,
							numeroDni: ndoc,
							horaIngreso: inicio,
							horaSalida: fin
						},
						success: function(response){
							alert(response.message);
							hasChanges = true;
						}
					});
				}
				
			});

	    @endfor

	    var id = 0;
	    $('#tablaProgramacion').on('click', '.edit, .delete', function(){
	    	id = $(this).data('id');
	    });

	    $('#add_horarios').click(function(){
	    	var ndoc = $('#txtDoc').val();
	    	if (!ndoc) {
	    		alert('Primero ingrese el Nro. Documento del Trabajador');
	    		$('#txtDoc').focus();
	    		return false;
	    	}
	    	var index = $('#add_horarios').data('index');
	    	$('#tr'+index).show();
	    	$('#add_horarios').data('index', index+1);
	    });

	    $('#txtName').focus(function() {
	    	var ndoc = $('#txtDoc').val();
	    	if (!ndoc) {
	    		alert('Primero ingrese el Nro. Documento del Trabajador');
	    		$('#txtDoc').focus();
	    		return false;
	    	}
	    });

	    $('#txtName').focus(function() {
	    	var ndoc = $('#txtDoc').val();
	    	if (!ndoc) {
	    		$('#txtDoc').focus();
	    		return false;
	    	}
	    	$.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              }
            });

			$.ajax({
				url: "{{ url('mantenimiento/trabajador/') }}" + '/' + ndoc,
				method: 'get',
				success: function(response){
					var tt = response.trabajador;
					if (tt == 0) {
					}
					else {
						$('#TrabajadorId').val(tt.idTrabajador);
						$('#txtCode').val(tt.codigoTrabajador);
						$('#txtName').val(tt.apellidoPaterno + ' ' + tt.apellidoMaterno + ' ' + tt.nombreTrabajador);
					}
				}
			});
	    });

	    $('#new').on('show.bs.modal', function(){
	    	if (id != 0) {
	    		$('#add_horarios').hide();
		    	$.ajaxSetup({
	              headers: {
	                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	              }
	            });

				$.ajax({
					url: "{{ url('viajes/validacion/getTrabajador/') }}",
					method: 'post',
					data: {
						idsViajeDetalle: id
					},
					success: function(response){
						var data = response.data;
						var trabajador = data.trabajador;
						var horarios = data.horarios;
						//llenando datos del trabajador
						$('#txtDoc').val(trabajador.nro_documento);
						$('#txtCode').val(trabajador.codigo);
						$('#txtName').val(trabajador.trabajador);
						//lenando horarios
						for (var i = 0; i < horarios.length; i++) {
							$('#tr'+i).show();
							$('#TrabajadorId').val(id);
							$('#fecha_inicio'+i).val(horarios[i].fecha_inicio);
							$('#hora_inicio'+i).val(horarios[i].hora_inicio);
							$('#fecha_fin'+i).val(horarios[i].fecha_fin);
							$('#hora_fin'+i).val(horarios[i].hora_fin);
							$('#save'+i).data('viajedetalle_id', horarios[i].idViajeDetalle);
							$('#add_horarios').data('index', i);
						}
					}
				});
	    	}
	    	else {
	    		$('#add_horarios').show();
	    		$('#new form').trigger('reset');
	    		for (var i = 0; i < 1; i++) {
	    			$('#tr'+i).hide();
	    			$('#save'+i).data('viajedetalle_id', '');
	    			$('#fecha_inicio'+i).val(cabecera[0].horaInicio.substring(0, 10));
					$('#hora_inicio'+i).val(cabecera[0].horaInicio.substring(11, 16));
					$('#fecha_fin'+i).val(cabecera[0].horaFin.substring(0, 10));
					$('#hora_fin'+i).val(cabecera[0].horaFin.substring(11, 16));
					$('#add_horarios').data('index', 0);
	    		}
	    	}
	    });

	    $('#delete').on('show.bs.modal', function(){
	    	$('#txtidViajeDetalleR').val(id);
	    });

	    $('#new, #delete, #approve, #desapprove').on('hide.bs.modal', function(){
	    	id = 0;
	    	if (hasChanges) {
	    		location.reload();
	    	}
	    });

		$('#centrocosto, #conductor, #vehiculo, #horaFin, #horaInicio').change(function () {
			$('#hasEdit').show();
		})

		$('#changeCabecera').submit(function (e) {
			e.preventDefault();
			$('.disabled').removeAttr('disabled');
			$('#idViaje').val(cabecera[0].idViaje);
			$('#idPlanificacion').val(cabecera[0].idPlanificacionViaje);
			var data = $(this).serialize() + '&horaInicioV='+cabecera[0].horaInicio + '&horaFinV='+cabecera[0].horaFin + '&fecha='+cabecera[0].fecha.substring(0, 10) + '&hora='+cabecera[0].hora.substring(0, 5) + '&tarifa='+cabecera[0].idTarifa + '&precio_final='+cabecera[0].precio_final;
			console.log(data);
			$.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              }
            });

			$.ajax({
				url: "{{ url('viajes/realizados/editar') }}",
				method: 'post',
				data: data,
				success: function(response){
					var rpt_success = response.success;
					if (rpt_success.substring(0,1) == '1') {
						$('#alert-message').html(rpt_success.substring(2));
						$('#alert').show();
						$('#hasEdit').hide();
						$('.disabled').attr('disabled', true);
					}
				}
			});

		})

		$(document).ready(function () {
			$('#hasEdit').hide();
			for (var i = 0; i < empresas.length; i++) {
                ("{{Auth::user()->idEmpresa}}".split('-')).forEach(function(idEmpresa) {
					if(idEmpresa == empresas[i].idEmpresa)
						$('#empresa').append('<option value="'+empresas[i].idEmpresa+'">'+empresas[i].razonSocial+'</option>');								
				});
			}
			for (var i = 0; i < transportistas.length; i++) {
				$('#transportista').append('<option value="'+transportistas[i].idProveedor+'">'+transportistas[i].razonSocial+'</option>');
			}

			$('#empresa').val(cabecera[0].idEmpresa);
			$('#empresa').trigger('change');
			//$('#area').val(cabecera[0].idArea);
			$('#centrocosto').val(cabecera[0].idCentroCosto);
			$('#transportista').val(cabecera[0].idProveedor);
			$('#transportista').trigger('change');
			$('#ruta').val(cabecera[0].idRuta);
			$('#tipoVehiculo').val(cabecera[0].idTipoVehiculo);
			$('#tipoViaje').val(cabecera[0].idTipoTarifa);
			$('#conductor').val(cabecera[0].idConductor);
			$('#vehiculo').val(cabecera[0].idVehiculo);
			console.log(cabecera[0].horaInicio.substring(11, 16));
			$('#horaInicio').val(cabecera[0].horaInicio.substring(11, 16));
			$('#horaFin').val(cabecera[0].horaFin.substring(11, 16));
		})

		$('#empresa').change(function () {
			var idEmpresa = $(this).val();
			/*for (var i = 0; i < areas.length; i++) {
				if (idEmpresa == areas[i].idEmpresa) {
					$('#area').append('<option value="'+areas[i].idArea+'">'+areas[i].nombreArea+'</option>');
				}
			}*/
			for (var i = 0; i < centrocostos.length; i++) {
				if (idEmpresa == centrocostos[i].idEmpresa) {
					$('#centrocosto').append('<option value="'+centrocostos[i].idCentroCosto+'">'+centrocostos[i].nombreCentroCosto+'</option>');
				}
			}
		});

		$('#transportista').change(function () {
			var idTransportista = $(this).val();

			$('#ruta').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			$('#tipoViaje').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			$('#tipoVehiculo').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			$('#conductor').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			$('#vehiculo').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');

			for (var i = 0; i < rutas.length; i++) {
				$('#ruta').append('<option value="'+rutas[i].idRuta+'">'+rutas[i].origen+'-'+rutas[i].destino+'</option>')
			}

			for (var i = 0; i < tiposViajes.length; i++) {
				if (idTransportista == tiposViajes[i].idProveedor) {
					$('#tipoViaje').append('<option value="'+tiposViajes[i].idTipoTarifa+'">'+tiposViajes[i].nombreTipoTarifa+'</option>');
				}
			}

			for (var i = 0; i < tiposVehiculos.length; i++) {
    if(idTransportista == tiposVehiculos[i].idProveedor)
				$('#tipoVehiculo').append('<option value="'+tiposVehiculos[i].idTipoVehiculo+'">'+tiposVehiculos[i].nombreTipoVehiculo+'</option>');
			}

			for (var i = 0; i < vehiculos.length; i++) {
				if (vehiculos[i].idProveedor == idTransportista)
					$('#vehiculo').append('<option value="'+vehiculos[i].idVehiculo+'">'+vehiculos[i].placaVehiculo+'</option>');
			}

			for (var i = 0; i < conductores.length; i++) {
				if (idTransportista == conductores[i].idProveedor) {
					$('#conductor').append('<option value="'+conductores[i].idConductor+'">'+conductores[i].nombreConductor+'</option>');
				}
			}
		});


	</script>
@endsection