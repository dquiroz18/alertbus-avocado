<?php $__env->startSection('main-content'); ?>
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
	               <span>Operaciones</span>
	               <span> >> </span>
	               <span class="active"><a href="<?php echo e(url('viajes/programados')); ?>">Copiar Programación</a></span>
	           </div>
	       </div>
	    </div>
	    <div class="x_panel">
        	<div class="x_title">
	            <h2>Copiar Viajes Programados</h2>
	            <ul class="nav navbar-right panel_toolbox">
	            	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
	            <div class="clearfix"></div>
          	</div>
        	<div class="x_content">
        		<div class="row">
                    <div class="form-group col-sm-3">
                        <label for="fecha">Fecha</label>
                        <input type="date" name="fecha" id="fecha" value="<?php echo e(date('Y-m-d')); ?>" class="form-control">
                    </div>
                </div>
        		<div class="row">
        			<div class="form-group col-sm-3">
        				<label for="Empresa">Empresa</label>
						<select name="empresa" id="empresa" class="form-control">
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="form-group col-sm-3">
        				<label for="centrocosto">Centro de Costo</label>
						<select name="centrocosto" id="centrocosto" class="form-control">
							<option value="0">Seleccione</option>
						</select>
        			</div>
        		</div>
        		<div class="row">
        			<div class="form-group col-sm-3">
        				<label for="transportista">Transportista</label>
						<select name="transportista" id="transportista" class="form-control">
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="form-group col-sm-3">
        				<label for="ruta">Ruta</label>
						<select name="ruta" id="ruta" class="form-control">
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="col-sm-3">
						<label for="placa">Placa</label> 
						<select id="placa" class="form-control">
							<option value="0">Seleccione</option>
						</select>
					</div>
        			<div class="form-group col-sm-3" style="display: none;">
        				<label for="tipoViaje">Tipo Tarifa</label>
						<select name="tipoViaje" id="tipoViaje" class="form-control">
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="form-group col-sm-1">
        				<label>Buscar</label> <br>
        				<button type="button" class="btn btn-primary" id="filtrarViajes">
        					<i class="fa fa-search"></i>
        				</button>
        			</div>
        			 <div class="col-sm-2">
			        	<button type="button" data-toggle="modal" id="copyProgramacion" data-target="#modal" class="btn btn-primary" style="position: relative; margin-top: 25px"><i class="fa fa-copy"></i> Copiar</button>
			        </div>
        		</div>
            </div>
        </div>
        <div class="x_panel">
        	<div class="x_content">
        		<div class="row">
        			<div class="col-sm-4">
			        	<div class="checkbox">
			        		<label>
			        			<input type="checkbox" id="all"> Seleccionar Todos los registros 
			        		</label>
			        	</div>
			        </div>
        		</div>
        		<div class="row">
        			<div class="col-sm-12">
				        <table class="table table-hover table-striped table-bordered" id="tablaProgramacion">
				            <thead>
				                <tr>
				                    <th></th>
				                	<th width="50px">Nro.</th>
				                    <th>Empresa</th>
				                    <th>Fecha</th>
				                    <th>Centro Costo</th>
				                    <th>Transportista</th>
				                    <th>Ruta</th>
				                    <!-- <th>Tipo Tarifa</th>  -->
				                    <th width="80px">Tarifa</th>
				                </tr>
				            </thead>
				        </table>
        			</div>
        		</div>
        	</div>
        </div>
	</div>
	<input type="checkbox" style="display: none" class="tocopy" data-id="0">
	<div class="modal fade" tabindex="-1" role="dialog" id="modal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h3 class="modal-title" style="font-weight: bold;">Copiar Programación</h3>	       	
	      </div>
	      <form id="form_eliminar">
	      <div class="modal-body">
	      	<div class="row">
	      		<div class="col-sm-8">
		        	<div class="form-group">
		        		<label>Cada registro seleccionado se programará para las siguientes fechas</label>
		        		<div class="input-group">
		        			<input type="date" name="desde" id="desde" class="form-control"  value="<?php $date = new \Datetime(); $date->modify('+1 day'); echo $date->format('Y-m-d') ?>" >
		        			<span class="input-group-addon">hasta</span>
		        			<input type="date" name="hasta" id="hasta" class="form-control"  value="<?php $date = new \Datetime(); $date->modify('+2 day'); echo $date->format('Y-m-d') ?>" >
		        		</div>
		        	</div>
		        </div>
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="button" class="btn btn-primary" id="aceptar">Aceptar</button>
	      </div>
	      </form>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<script>
		var atLeastOne = false;
		$('#copyProgramacion').click(function() {
			atLeastOne = false;
			$('.tocopy').each(function() {
				if ($(this).is(':checked')) {
					atLeastOne = true;
				}
			});
			if (!atLeastOne) {
				alert("Seleccione al menos un registro para copiar la programacion");
				$(this).removeAttr('data-target');
				$(this).attr('data-target', '#nana');
			}
			else {
				$(this).removeAttr('data-target');
				$(this).attr('data-target', '#modal');
			}
		});

		

		var empresas = <?php echo json_encode($empresas); ?>;
		var centrocostos = <?php echo json_encode($centrocostos); ?>;
		var transportistas = <?php echo json_encode($transportistas); ?>;
		var tiposViajes = <?php echo json_encode($tiposViajes); ?>;
		var placas = <?php echo json_encode($vehiculos); ?>;
		var rutas = <?php echo json_encode($rutas); ?>;

		$('#asignacion').on('show.bs.modal', function () {
			$('#form_asignacion').trigger("reset");
		});

		$('#all').click(function () {
			if ($(this).is(':checked')) {
				$('.tocopy').each(function () {
					$(this).prop('checked', true)
				})	
			}
			else {
				$('.tocopy').each(function () {
					$(this).prop('checked', false)
				})	
			}
			
		})

		$(document).ready(function () {
			for (var i = 0; i < empresas.length; i++) {
				$('#empresa').append('<option value="'+empresas[i].idEmpresa+'">'+empresas[i].razonSocial+'</option>');
			}
			for (var i = 0; i < transportistas.length; i++) {
				$('#transportista').append('<option value="'+transportistas[i].idProveedor+'">'+transportistas[i].razonSocial+'</option>');
			}
		});

		$('#empresa').change(function () {
			var idEmpresa = $(this).val();
			$('#centrocosto').html('<option value="0">Seleccione</option>');
			for (var i = 0; i < centrocostos.length; i++) {
				if (idEmpresa == centrocostos[i].idEmpresa) {
					$('#centrocosto').append('<option value="'+centrocostos[i].idCentroCosto+'">'+centrocostos[i].nombreCentroCosto+'</option>');
				}
			}
		});

		$('#transportista').change(function () {
			var idTransportista = $(this).val();

			$('#ruta').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			$('#placa').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');
			$('#tipoViaje').find('option').remove().end().append('<option value="0">Seleccione</option>').val('0');

			for (var i = 0; i < rutas.length; i++) {
				$('#ruta').append('<option value="'+rutas[i].idRuta+'">'+rutas[i].origen+'-'+rutas[i].destino+'</option>')
			}

			for (var i = 0; i < tiposViajes.length; i++) {
				if (idTransportista == tiposViajes[i].idProveedor) {
					$('#tipoViaje').append('<option value="'+tiposViajes[i].idTipoTarifa+'">'+tiposViajes[i].nombreTipoTarifa+'</option>');
				}
			}
			for (var i = 0; i < placas.length; i++) {
				if (idTransportista == placas[i].idProveedor) {
					$('#placa').append('<option value="'+placas[i].idVehiculo+'">'+placas[i].placaVehiculo+'</option>');
				}
			}
		});

		$('#desde, #hasta').change(function() {
			out_estado = 1;
		});

		var tablaProgramacion = $('#tablaProgramacion').DataTable();



		$('#filtrarViajes').click(function () {
			$('#loading').show();
			$('#tabla').hide();
			var idEmpresa = $('#empresa').val();
			if (idEmpresa == 0) {
				alert("Seleccione una Empresa");
				return ;
			}
			var idCentroCosto = $('#centrocosto').val();
			var idTransportista = $('#transportista').val();
			var idTipoTarifa = $('#tipoViaje').val();
			var idRuta = $('#ruta').val();

			var desde = $('#fecha').val();
			var hasta = $('#fecha').val();

			var buscar_http = "<?php echo e(url('viajes/programados/')); ?>" + '/' + idEmpresa
																 + '/' + idCentroCosto
																 + '/' + idTransportista
																 + '/' + idTipoTarifa
																 + '/' + idRuta
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
						tablaProgramacion.row.add([
							'<input type="checkbox" data-id="'+data[i].idPlanificacionViaje+'" class="tocopy" />',
							nrofila,
							data[i].nombreEmpresa,
							data[i].fecha,
							data[i].nombreCentroCosto,
							data[i].nombreProveedor,
							data[i].nombreRuta,
							//data[i].nombreTipoTarifa,
							data[i].tarifa
						]).draw()
						nrofila += 1;
					}
					$('#loading').hide();
					$('#tabla').show();
				}
			});
		});
		var out_estado = 1;
		$('#aceptar').click(function () {
			var idEmpresa = $('#empresa').val();
			if (idEmpresa == 0) {
				alert("Seleccione una Empresa");
				return ;
			}
			var ids = [];
			var desde = $('#desde').val();
			var hasta = $('#hasta').val();
			$('.tocopy').each(function () {
				if ($(this).is(':checked')) {
					ids.push($(this).data('id'));
				}
			});

			$.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              }
            });

			$.ajax({
				url: "<?php echo e(url('viajes/programados/copiar')); ?>",
				method: 'post',
				data: {
					idEmpresa: idEmpresa,
					ids: ids,
					desde: desde,
					hasta: hasta,
					estado: out_estado
				},
				success: function(response){
					var estado = response.message.substring(0, 1);
					var rpt_message = response.message.substring(2);
					if (estado == 0) {
						rpt_message = rpt_message + '<br> <a href="#" id="yes">Sí</a> <a href="#" id="no">No</a>';
					}
					$('#alert-message').html(rpt_message);
					$('#alert').show();
					$('#modal').modal('hide')
				}
			});

		});

		$('#alert-message').on('click', '#yes', function () {
			out_estado = 0;
			$('#aceptar').trigger('click');
		});

		$('#alert-message').on('click', '#no', function () {
			$('#alert-close').trigger('click');
		});

	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>