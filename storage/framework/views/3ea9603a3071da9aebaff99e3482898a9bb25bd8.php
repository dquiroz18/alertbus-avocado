<?php $__env->startSection('main-content'); ?>
<style>
		.divtable {
			 overflow-x: hidden;
			overflow-y: hidden;
    		white-space: nowrap;
		}
	</style>
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
	    <div class="row">
	       <div class="col-xs-12">
	           <div class="breadcrumbs">
	               <span>Reportes</span>
	               <span> >> </span>
	               <span class="active"><a href="<?php echo e(url('viajes/programados')); ?>">Viajes Programados</a></span>
	           </div>
	       </div>
	    </div>
	    <div class="x_panel">
        	<div class="x_title">
	            <h2>Viajes Programados</h2>
	            <ul class="nav navbar-right panel_toolbox">
	            	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
	            <div class="clearfix"></div>
          	</div>
        	<div class="x_content">
        		<div class="row">
                    <div class="form-group col-sm-3">
                        <label for="desde">Desde</label>
                        <input type="date" name="desde" id="desde" value="<?php echo e(date('Y-m-d')); ?>" class="form-control">
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="hasta">Hasta</label>
                        <input type="date" name="hasta" id="hasta" class="form-control"  value="<?php $date = new \Datetime(); $date->modify('+1 day'); echo $date->format('Y-m-d') ?>" >
                    </div>
                </div>
        		<div class="row">
        			<div class="form-group col-sm-3">
        				<label for="Empresa">Empresa</label>
						<select name="empresa" id="empresa" class="form-control">
						</select>
        			</div>
        			<div class="form-group col-sm-3">
        				<label for="centrocosto">Centro Costo</label>  <br>
						<select name="centrocosto" id="centrocosto" class="form-control" style="width: 100%">
							<option value="0">Seleccione</option>
						</select>
        			</div>
        		</div>
        		<div class="row">
        			<div class="form-group col-sm-3">
        				<label for="transportista">Transportista</label> <br>
						<select name="transportista" id="transportista" class="form-control" style="width: 100%">
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="form-group col-sm-3">
        				<label for="ruta">Ruta</label> <br>
						<select name="ruta" id="ruta" class="form-control" style="width: 100%">
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="form-group col-sm-3" style="display: none;">
        				<label for="tipoViaje">Tipo Tarifa</label>
						<select name="tipoViaje" id="tipoViaje" class="form-control">
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="form-group col-sm-3">
        				<label for="placa">Placa</label>
						<select name="placa" id="placa" class="form-control">
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="form-group col-sm-1">
        				<label>Buscar</label> <br>
        				<button type="button" class="btn btn-primary" id="filtrarViajes">
        					<i class="fa fa-search"></i>
        				</button>
        			</div>
        		</div>
            </div>
        </div>
        <div class="x_panel">
        	<div class="x_content">
        		<div id="loading" class="col-sm-2 col-sm-offset-5" style="display: none;">
                    <img src="<?php echo e(asset('images/loading.gif')); ?>" alt="">
                </div>
                <div class="col-sm-12 divtable">
			        <table class="table table-hover table-striped table-bordered" id="tablaProgramacion">
			            <thead>
			                <tr>
			                	<th>Nro.</th>
			                    <th>Empresa</th>
			                    <th>Fecha</th>
			                    <!-- <th>Area</th> -->
			                    <th>Centro Costo</th>
			                    <th>Transportista</th>
			                    <th>Ruta</th>
			                    <th>Tipo Vehículo</th>
			                    <th>Tarifa</th>
			                    <th>Conductor</th>
			                    <th>Placa</th>
			                    <th>Notificado</th>
			                    <th>Estado</th>
			                    <?php if(Auth::user()->tipo == 'E' || Auth::user()->tipo == 'A'): ?>
			                    	<th>Editar</th>			                    	
			                    	<th>Eliminar</th>
									<th>Asignar</th>								
			                    <?php endif; ?>
			                </tr>
			            </thead>
			        </table>
                </div>
        	</div>
        </div>
	</div>
	
	<!-- editar viaje -->
	<div class="modal fade" tabindex="-1" role="dialog" id="editar">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       	<h3 class="modal-title" style="font-weight: bold;">Editar Viaje</h3>
	      </div>
	      <form id="form_editar">
	      <div class="modal-body">
	      	<div class="row">
    			<div class="form-group col-sm-3">
    				<label for="Empresa">Empresa</label>
					<select name="empresa" id="empresaE" class="form-control">
					</select>
    			</div>
    			<div class="form-group col-sm-3"  style="display: none;">
    				<label for="area">Area</label>
					<select name="area" id="areaE" class="form-control">
						<option value="0">Seleccione</option>
					</select>
    			</div>
    			<div class="form-group col-sm-3">
    				<label for="centrocosto">Centro de Costo</label> <br>
					<select name="centrocosto" id="centrocostoE" class="form-control" style="width: 100%">
						<option value="0">Seleccione</option>
					</select>
    			</div>
    		</div>
	        <div class="row">
                <div class="form-group col-sm-3">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fechaE" class="form-control">
                </div>
                <div class="form-group col-sm-3">
                    <label for="hora">Hora</label>
                    <input type="time" name="hora" id="horaE" class="form-control" >
                </div>
            </div>
    		<div class="row">
    			<div class="form-group col-sm-3">
    				<label for="transportista">Transportista</label> <br>
					<select name="transportista" id="transportistaE" class="form-control" style="width: 100%">
						<option value="0">Seleccione</option>
					</select>
    			</div>
    			<div class="form-group col-sm-3"> 
    				<label for="ruta">Ruta</label> <br>
					<select name="ruta" id="rutaE" class="form-control"  style="width: 100%">
						<option value="0">Seleccione</option>
					</select>
    			</div>
    			<div class="form-group col-sm-3">
    				<label for="tipoVehiculo">Tipo Vehiculo</label>
					<select name="tipoVehiculo" id="tipoVehiculoE" class="form-control">
						<option value="0">Seleccione</option>
					</select>
    			</div>
    			<div class="form-group col-sm-3" style="display: none;">
    				<label for="tipoViaje">Tipo Tarifa</label>
					<select name="tipoViaje" id="tipoViajeE" class="form-control">
						<option value="0">Seleccione</option>
					</select>
    			</div>
    			<div class="form-group col-sm-3" style="display: none;">
    				<label for="placa">Placa</label>
					<select name="placa" id="placaE" class="form-control">
						<option value="0">Seleccione</option>
					</select>
    			</div>
    		</div>
    		<div class="row">
    			<div class="form-group col-sm-3">
    				<label for="tarifa">Tarifa</label>
					<select name="tarifa" id="tarifaE" class="form-control"></select>
    			</div>
    			<div class="form-group col-sm-3">
    				<label for="precio_final">Tarifa Final</label>
					<input name="precio_final" id="precio_finalE" class="form-control">
    			</div>
    		</div>
	        <input type="hidden" id="idPlanificacionE" name="idPlanificacion">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" class="btn btn-warning">Editar</button>
	      </div>
	      </form>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!-- eliminar viaje -->
	<div class="modal fade" tabindex="-1" role="dialog" id="eliminar">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       	<h3 class="modal-title" style="color: red; font-weight: bold;">Eliminar Viaje</h3>
	      </div>
	      <form id="form_eliminar">
	      <div class="modal-body">
	      	<p>
	      		¿Desea eliminar el Viaje?
	      	</p>
	        <input type="hidden" id="idPlanificacionD" name="idPlanificacion">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" class="btn btn-danger">Eliminar</button>
	      </div>
	      </form>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- asignar conductor y vehiculo -->
	<div class="modal fade" tabindex="-1" role="dialog" id="asignacion">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	       	<h3 class="modal-title" style="font-weight: bold;">Asignar Conductor y Vehículo</h3>
	      </div>
	      <form id="form_asignacion">
	      <div class="modal-body">
	        <div class="row">
	        	<div class="col-sm-5 form-group">
	        		<label>Conductor</label> <br>
	        		<select name="idConductor" id="idConductor" class="form-control" style="width: 100%">
	        			<option value="0">Seleccione</option>
	        		</select>
	        		<!-- 
	        		<input type="hidden" name="idConductor" id="idConductor">
	        		<input type="text" id="fullNameConductor" autocomplete="off">
	        		<div class="suggest-items">
	        			
	        		</div>
	        		 -->
	        	</div>
	        	<div class="col-sm-3 form-group">
	        		<label>Placa</label> <br>
	        		<select name="idVehiculo" id="idVehiculo" class="form-control" style="width: 100%">
	        			<option value="0">Seleccione</option>
	        		</select>
	        		<!-- 
	        		<input type="hidden" name="idVehiculo" id="idVehiculo">
	        		<input type="text" id="placaVehiculo" autocomplete="off">
	        		<div class="suggest-items">
	        			
	        		</div>
	        		-->
	        	</div>
	        	<div class="col-sm-3 form-group">
	        		<label>Capacidad</label>
	        		<input type="text" id="showPlaca" class="form-control" readonly>
	        	</div>
	        </div>
	        <input type="hidden" id="idPlanificacion" name="idPlanificacion">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" class="btn btn-primary">Asignar</button>
	      </div>
	      </form>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<script>
		$('#transportista, #ruta, #centrocosto, #placa').select2();
		$('#transportistaE, #rutaE, #centrocostoE').select2({
			dropdownParent: $('#editar')
		});
		$('#idConductor, #idVehiculo').select2({
			dropdownParent: $('#asignacion')
		});
	</script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script>
		var empresas = <?php echo json_encode($empresas); ?>;
		//var areas = <?php echo json_encode($areas); ?>;
		var centrocostos = <?php echo json_encode($centrocostos); ?>;
		var transportistas = <?php echo json_encode($transportistas); ?>;
		var tiposViajes = <?php echo json_encode($tiposViajes); ?>;
		var rutas = <?php echo json_encode($rutas); ?>;

		var vehiculos = <?php echo json_encode($vehiculos); ?>;
		var conductores = <?php echo json_encode($conductores); ?>;

		var tiposVehiculos =  <?php echo json_encode($tiposVehiculos); ?>;
		var tarifas =  <?php echo json_encode($tarifas); ?>;

	$('#asignacion').on('show.bs.modal', function () {
		$('#form_asignacion').trigger("reset");
	});
	var lastPage = 0;
	$('#tablaProgramacion').on( 'page.dt', function () {
		var info = tablaProgramacion.page.info();
		lastPage = info.page;
	});
		$(document).ready(function () {
			tablaProgramacion.buttons().container().prependTo( tablaProgramacion.table().container() );

			for (var i = 0; i < rutas.length; i++) {
				$('#ruta').append('<option value="'+rutas[i].idRuta+'">'+rutas[i].origen+'-'+rutas[i].destino+'</option>')
			}

			for (var i = 0; i < rutas.length; i++) {
				$('#rutaE').append('<option value="'+rutas[i].idRuta+'">'+rutas[i].origen+'-'+rutas[i].destino+'</option>')
			}
			for (var i = 0; i < empresas.length; i++) {
				("<?php echo e(Auth::user()->idEmpresa); ?>".split('-') ).forEach(function(idEmpresa) {
					if(idEmpresa == empresas[i].idEmpresa){
						$('#empresa').append('<option value="'+empresas[i].idEmpresa+'">'+empresas[i].razonSocial+'</option>');
						$('#empresaE').append('<option value="'+empresas[i].idEmpresa+'">'+empresas[i].razonSocial+'</option>');	
					}
				});
				$("#empresa option:first").attr('selected','selected');
				$('#empresa').trigger('change');
				$("#empresaE option:first").attr('selected','selected');
				$('#empresaE').trigger('change');
			}
		});

		$('#empresa').change(function () {
			var idEmpresa = $(this).val();
			$('#centrocosto').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			for (var i = 0; i < centrocostos.length; i++) {
				if (idEmpresa == centrocostos[i].idEmpresa) {
					$('#centrocosto').append('<option value="'+centrocostos[i].idCentroCosto+'">'+centrocostos[i].nombreCentroCosto+'</option>');
				}
			}
			$('#transportista').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			for (var i = 0; i < transportistas.length; i++) {
				if (transportistas[i].idEmpresa.includes(idEmpresa)){
				<?php if(Auth::user()->tipo=='T'): ?>
					var idTransportista = <?php echo e(Auth::user()->idProveedor); ?>;
					if (idTransportista == transportistas[i].idProveedor) {
						$('#transportista').append('<option value="'+transportistas[i].idProveedor+'">'+transportistas[i].razonSocial+'</option>');
					}
				<?php else: ?>
					$('#transportista').append('<option value="'+transportistas[i].idProveedor+'">'+transportistas[i].razonSocial+'</option>');
				<?php endif; ?>
				}
			}
			<?php if(Auth::user()->tipo=='T'): ?>
				$("#transportista").val($("#transportista option:eq(1)").val());
				$('#transportista').trigger('change');
			<?php endif; ?>
		});

		$('#empresaE').change(function () {
			var idEmpresa = $(this).val();
			$('#centrocostoE').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			for (var i = 0; i < centrocostos.length; i++) {
				if (idEmpresa == centrocostos[i].idEmpresa) {
					$('#centrocostoE').append('<option value="'+centrocostos[i].idCentroCosto+'">'+centrocostos[i].nombreCentroCosto+'</option>');
				}
			}
			/*$('#areaE').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			for (var i = 0; i < areas.length; i++) {
				if (idEmpresa == areas[i].idEmpresa) {
					$('#areaE').append('<option value="'+areas[i].idArea+'">'+areas[i].nombreArea+'</option>');
				}
			}*/
			$('#transportistaE').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			for (var i = 0; i < transportistas.length; i++) {
				if (transportistas[i].idEmpresa.includes(idEmpresa)){
				<?php if(Auth::user()->tipo=='T'): ?>
					var idTransportista = <?php echo e(Auth::user()->idProveedor); ?>;
					if (idTransportista == transportistas[i].idProveedor) {
						$('#transportistaE').append('<option value="'+transportistas[i].idProveedor+'">'+transportistas[i].razonSocial+'</option>');
					}
				<?php else: ?>
					$('#transportistaE').append('<option value="'+transportistas[i].idProveedor+'">'+transportistas[i].razonSocial+'</option>');
				<?php endif; ?>
				}
			}
			<?php if(Auth::user()->tipo=='T'): ?>
				$("#transportistaE").val($("#transportistaE option:eq(1)").val());
				$('#transportistaE').trigger('change');
			<?php endif; ?>
		});

		$('#transportista').change(function () {
			var idTransportista = $(this).val();

			$('#tipoViaje').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			$('#placa').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');


			for (var i = 0; i < tiposViajes.length; i++) {
				if (idTransportista == tiposViajes[i].idProveedor) {
					$('#tipoViaje').append('<option value="'+tiposViajes[i].idVehiculo+'">'+tiposViajes[i].placaVehiculo+'</option>');
				}
			}

			for (var i = 0; i < vehiculos.length; i++) {
				if (idTransportista == vehiculos[i].idProveedor) {
					$('#placa').append('<option value="'+vehiculos[i].idVehiculo+'">'+vehiculos[i].placaVehiculo+'</option>');
				}
			}
		});

		$('#transportistaE').change(function () {
			var idTransportista = $(this).val();

			$('#tipoViajeE').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			$('#tipoVehiculoE').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			$('#placaE').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');

			for (var i = 0; i < tiposViajes.length; i++) {
				if (idTransportista == tiposViajes[i].idProveedor) {
					$('#tipoViajeE').append('<option value="'+tiposViajes[i].idTipoTarifa+'">'+tiposViajes[i].nombreTipoTarifa+'</option>');
				}
			}

			for (var i = 0; i < vehiculos.length; i++) {
				if (idTransportista == vehiculos[i].idProveedor) {
					$('#placaE').append('<option value="'+vehiculos[i].idVehiculo+'">'+vehiculos[i].placaVehiculo+'</option>');
				}
			}

			for (var i = 0; i < tiposVehiculos.length; i++) {
    		if(idTransportista == tiposVehiculos[i].idProveedor)
				$('#tipoVehiculoE').append('<option value="'+tiposVehiculos[i].idTipoVehiculo+'">'+tiposVehiculos[i].nombreTipoVehiculo+'</option>');
			}

			$('#tipoVehiculoE').trigger('change');

		});

		$('#tarifaE').change(function() {
			var valor = $(this).find('option:selected').text();
			if (valor != "Seleccione") $('#precio_finalE').val(parseFloat(valor).toFixed(2));
			else $('#precio_finalE').val('0');
		});

		$('#tipoVehiculoE').change(function () {

			var idTipoVehiculo = $(this).val();

			var idRuta = $('#rutaE').val();

			var idTransportista = $('#transportistaE').val();

			var fecha = $('#fechaE').val();

			$('#tarifaE').find('option').remove().end();
			$('#tarifaE').append('<option value="0">Seleccione</option>');
			var existe = false;
			for (var i = 0; i < tarifas.length; i++) {
				if (idRuta == tarifas[i].idRuta &&
					idTipoVehiculo == tarifas[i].idTipoVehiculo
					 ) {
					existe = true;
					var idTarifa = tarifas[i].idTarifa;
					var precio = tarifas[i].precio;
					$('#tarifaE').append('<option value="'+tarifas[i].idTarifa+'">'+tarifas[i].precio+'</option>');
				}
			}
			if (!existe)
				$('#tarifaE').val('0')
			else
				$('#tarifaE').find('option:last').attr("selected", "selected");
			$('#tarifaE').trigger('change')
		});

		$('#rutaE').change( function () {
			$('#tipoVehiculoE').trigger('change');

		});

		$('#fechaE').change( function () {
			$('#tipoVehiculoE').trigger('change');
		});

		var tablaProgramacion = $('#tablaProgramacion').DataTable({
			order: [],
	        buttons: [
	            {
	                extend: 'excelHtml5',
	                title: 'Viajes Programados',
	                exportOptions: {
	                	columns : [0, 1, 2, 3, 4, 5, 6, 7 ,8 ,9, 10, 11]
	                }
	            }
	        ]
		});

		$('#filtrarViajes').click(function () {
			$('#loading').show();
			$('#tablaProgramacion').hide();
			var idEmpresa = $('#empresa').val();
			var idCentroCosto = $('#centrocosto').val();
			var idTransportista = $('#transportista').val();
			var idRuta = $('#ruta').val();
			var idVehiculo = $('#placa').val();

			var desde = $('#desde').val();
			var hasta = $('#hasta').val();

			<?php if(Auth::user()->tipo == 'T'): ?>
			if (idTransportista == 0) {
				alert("Seleccione el Transportista");
				$('#loading').hide();
				$('#tabla').show();
				return false;
			}
			<?php endif; ?>

			var buscar_http = "<?php echo e(url('viajes/programados/')); ?>" + '/' + idEmpresa
																 + '/' + idCentroCosto
																 + '/' + idTransportista
																 + '/' + idRuta
																 + '/' + idVehiculo
																 + '/' + desde
																 + '/' + hasta;

			$.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              }
            });

			$.ajax({
				url: buscar_http,
				method: 'get',
				success: function(response){
					tablaProgramacion.clear().draw();
					var data = response.dataset;
					var nrofila = 1;
					for (var i = 0; i < data.length; i++) {
						<?php if(Auth::user()->tipo=='T'): ?>

							tablaProgramacion.row.add([
								nrofila,
								data[i].nombreEmpresa,
								data[i].fecha,
								//data[i].nombreArea,
								data[i].nombreCentroCosto,
								data[i].nombreProveedor,
								data[i].nombreRuta,
								data[i].nombreTipoVehiculo,
								//data[i].nombreTipoTarifa,
								data[i].tarifa,
								data[i].nombreConductor,
								data[i].placaVehiculo,
								data[i].notificado,
								data[i].estado
							]).draw()
							nrofila += 1;
						<?php endif; ?>

						<?php if(Auth::user()->tipo=='E' || Auth::user()->tipo=='A'): ?>
							
							if (data[i].estado == 'PROGRAMADO') {
								var button = '<button type="button" class="btn btn-primary asignacion" data-toggle="modal" data-target="#asignacion" data-idplanificaion="'+data[i].idPlanificacionViaje+'" data-idtransportista="'+data[i].idProveedor+'" data-tipovehiculo="'+data[i].idTipoVehiculo+'"><i class="fa fa-check"></i></button>';
								var button3 = '<button type="button" class="btn btn-danger eliminar" data-toggle="modal" data-target="#eliminar" data-idplanificaion="'+data[i].idPlanificacionViaje+'"><i class="fa fa-remove"></i></button>';
								var button2 = '<button type="button" class="btn btn-warning editar" data-toggle="modal" data-target="#editar" data-idplanificaion="'+data[i].idPlanificacionViaje+'"><i class="fa fa-edit"></i></button>';
							}
							else if (data[i].estado == 'TRANSBORDO'){
								var button = '<button type="button" class="btn btn-primary" disabled><i class="fa fa-check"></i></button>';	
								var button2 = '<button type="button" class="btn btn-warning editar" data-toggle="modal" data-target="#editar" data-idplanificaion="'+data[i].idPlanificacionViaje+'"><i class="fa fa-edit"></i></button>';
								var button3= '<button type="button" class="btn btn-danger" disabled><i class="fa fa-remove"></i></button>';	
							}
							else {
								var button = '<button type="button" class="btn btn-primary" disabled><i class="fa fa-check"></i></button>';	
								var button2= '<button type="button" class="btn btn-warning" disabled><i class="fa fa-edit"></i></button>';	
								var button3= '<button type="button" class="btn btn-danger" disabled><i class="fa fa-remove"></i></button>';	
							}
							tablaProgramacion.row.add([
								nrofila,
								data[i].nombreEmpresa,
								data[i].fecha,
								//data[i].nombreArea,
								data[i].nombreCentroCosto,
								data[i].nombreProveedor,
								data[i].nombreRuta,
								data[i].nombreTipoVehiculo,
								//data[i].nombreTipoTarifa,
								data[i].tarifa,
								data[i].nombreConductor,
								data[i].placaVehiculo,
								data[i].notificado,
								data[i].estado,				
								button2,
								button3,
								button								
							]).draw()
							nrofila += 1;
						<?php endif; ?>
						
					}
					$('#loading').hide();
					$('#tablaProgramacion').show();
					tablaProgramacion.page.info();
					tablaProgramacion.page(lastPage).draw('page');
				}
			});
		});

		var modal_idTransportista = 0;
		var modal_idPlanificacion = 0;
		var modal_tipoVehiculo = 0;
		$('#tablaProgramacion').on('click', '.asignacion, .editar, .eliminar', function () {
			modal_idTransportista = $(this).data('idtransportista');
			modal_idPlanificacion = $(this).data('idplanificaion');
			modal_tipoVehiculo = $(this).data('tipovehiculo');

		});

		$('#idVehiculo').change(function() {
			var idVehiculo = $(this).val();
			for (var i = 0; i < vehiculos.length; i++) {
				if (idVehiculo == vehiculos[i].idVehiculo) {
					$('#showPlaca').val(vehiculos[i].capacidad);
					break;
				}
			}
		});

		$('#asignacion').on('show.bs.modal', function (e) {
			var idTransportista = modal_idTransportista;
			$('#idConductor').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			$('#idVehiculo').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');

			for (var i = 0; i < vehiculos.length; i++) {
				if (idTransportista == vehiculos[i].idProveedor && modal_tipoVehiculo == vehiculos[i].idTipoVehiculo) {
					$('#idVehiculo').append('<option value="'+vehiculos[i].idVehiculo+'">'+vehiculos[i].placaVehiculo+'</option>');
				}
			}

			for (var i = 0; i < conductores.length; i++) {
				if (idTransportista == conductores[i].idProveedor) {
					$('#idConductor').append('<option value="'+conductores[i].idConductor+'">'+conductores[i].nombreConductor+'</option>');
				}
			}
		})

		$('#form_asignacion').submit(function(e) {
			e.preventDefault();
			$('#idPlanificacion').val(modal_idPlanificacion);
			if ($('#idConductor').val() == '0') { alert("Seleccione un Conductor"); return false;}
			if ($('#idVehiculo').val() == '0') { alert("Seleccione un Vehiculo"); return false; }
			var data = $(this).serialize();
			console.log(data);
			$.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              }
            });

			$.ajax({
				url: "<?php echo e(url('viajes/asignar-conductor-placa')); ?>",
				method: 'post',
				data: data,
				success: function(response){
					var rpt_success = response.success;
					$('#asignacion').modal('hide');
					$('#alert').show();
					if (rpt_success == 1) {
						$('#filtrarViajes').trigger('click');
						$('#alert').find('.alert').removeClass('alert-danger');
						$('#alert').find('.alert').addClass('alert-success');
					}
					else {
						$('#alert').find('.alert').removeClass('alert-success');
						$('#alert').find('.alert').addClass('alert-danger');
					}
					$('#alert-message').html(response.message);
				}
			});
		});

		$('#form_eliminar').submit(function(e) {
			e.preventDefault();
			$('#idPlanificacionD').val(modal_idPlanificacion);
			var data = $(this).serialize();
			console.log(data);
			$.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              }
            });

			$.ajax({
				url: "<?php echo e(url('viajes/programados/eliminar')); ?>",
				method: 'post',
				data: data,
				success: function(response){
					var rpt_success = response.success;
					if (rpt_success == 1) {
						$('#eliminar').modal('hide');
						$('#filtrarViajes').trigger('click');
						$('#alert-message').html("Viaje eliminado correctamente");
						$('#alert').show();
					}
				}
			});
		});

		$('#form_editar').submit(function(e) {
			e.preventDefault();
			if ($('#empresaE').val() == '0') {alert("Seleccione una Empresa"); return false;}
			if ($('#centrocostoE').val() == '0') {alert("Seleccione un Centro de Costo"); return false;}
			if ($('#fechaE').val() == '') {alert("Seleccione una Fecha"); return false;}
			if ($('#horaE').val() == '') {alert("Seleccione una Hora"); return false;}
			if ($('#transportistaE').val() == '0') {alert("Seleccione un Transportista"); return false;}
			if ($('#rutaE').val() == '0') {alert("Seleccione una Ruta"); return false;}
			if ($('#tipoVehiculoE').val() == '0') {alert("Seleccione un Tipo de Vehiculo"); return false;}
			$('#idPlanificacionE').val(modal_idPlanificacion);
			var data = $(this).serialize();
			console.log(data);
			$.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              }
            });

			$.ajax({
				url: "<?php echo e(url('viajes/programados/editar')); ?>",
				method: 'post',
				data: data,
				success: function(response){
					var rpt_success = response.success;
					$('#editar').modal('hide');
					$('#alert').show();
					if (rpt_success == 1) {
						$('#filtrarViajes').trigger('click');
						$('#alert').find('.alert').removeClass('alert-danger');
						$('#alert').find('.alert').addClass('alert-success');
					}
					else {
						$('#alert').find('.alert').removeClass('alert-success');
						$('#alert').find('.alert').addClass('alert-danger');
					}
					$('#alert-message').html(response.message);
				}
			});
		});

		$('#editar').on('show.bs.modal', function () {
			$('#form_editar').trigger('reset');
			$.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              }
            });

			$.ajax({
				url: "<?php echo e(url('viajes/programados/')); ?>" + "/" + modal_idPlanificacion,
				method: 'get',
				success: function(response){
					var data = response.data;
					$('#empresaE').val(data.idEmpresa);
					$('#empresaE').trigger('change');
					$('#fechaE').val(data.fecha.substring(0, 10));
					$('#horaE').val(data.hora.substring(0, 5));
					//$('#areaE').val(data.idArea);
					$('#centrocostoE').val(data.idCentroCosto);
					$('#centrocostoE').trigger('change');
					$('#transportistaE').val(data.idProveedor);
					$('#transportistaE').trigger('change');
					$('#rutaE').val(data.idRuta);
					$('#rutaE').trigger('change');
					$('#tipoVehiculoE').val(data.idTipoVehiculo);
					$('#tipoViajeE').val(data.idTipoTarifa);
					$('#placaE').val(data.idVehiculo);
					$('#tipoVehiculoE').trigger('change');
					$('#tarifaE').val(data.idTarifa);
					$('#tarifaE').trigger('change');
				}
			});
		})

	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>